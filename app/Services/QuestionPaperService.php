<?php

namespace App\Services;

use App\Models\Test;
use App\Models\Question;
use App\Models\TestAttempt;
use App\Models\UserAnswer;
use App\Enums\QuestionType;
use App\Enums\Difficulty;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Exception;

class QuestionPaperService
{
    /**
     * Generate question paper for a test
     */
    public function generateQuestionPaper(int $testId, ?int $userId = null): array
    {
        $userId = $userId ?? Auth::id();
        $test = $this->getTestById($testId);
        
        if (!$test) {
            throw new Exception('Test not found');
        }

        return Cache::remember("question_paper_{$testId}_user_{$userId}", 900, function () use ($test, $userId) {
            $questions = $this->getQuestionsForTest($test);
            
            // Shuffle questions if randomization is enabled
            if ($test->randomize_questions) {
                $questions = $questions->shuffle();
            }

            $settings = $this->getTestSettings($test);
            
            $questionPaper = [
                'test' => $test,
                'questions' => $questions,
                'user_progress' => $this->getUserTestProgress($test->id, $userId),
                'metadata' => $this->getQuestionPaperMetadata($test, $questions),
                'settings' => $settings,
                'navigation' => $this->buildQuestionNavigation($questions),
                'ai_hints_enabled' => $settings['enable_ai_hints'],
            ];

            return $questionPaper;
        });
    }

    /**
     * Get test by ID with validation
     */
    private function getTestById(int $testId): ?Test
    {
        return Test::where('id', $testId)
            ->where('is_active', true)
            ->where('is_public', true)
            ->with(['chapter', 'testAttempts'])
            ->first();
    }

    /**
     * Get questions for test based on test configuration
     */
    private function getQuestionsForTest(Test $test): Collection
    {
        // If test has predefined question_ids, use those
        if (!empty($test->question_ids) && is_array($test->question_ids)) {
            $questions = Question::whereIn('id', $test->question_ids)
                ->where('is_active', true)
                ->with(['options', 'chapter', 'topic'])
                ->get();
            
            if ($questions->isNotEmpty()) {
                return $questions;
            }
        }

        // Otherwise, generate questions dynamically based on test settings
        return $this->generateDynamicQuestions($test);
    }

    /**
     * Generate questions dynamically based on test settings
     */
    private function generateDynamicQuestions(Test $test): Collection
    {
        $query = Question::where('is_active', true)
            ->with(['options', 'chapter', 'topic']);

        // Filter by chapter if specified
        if ($test->chapter_id) {
            $query->where('chapter_id', $test->chapter_id);
        }

        // Filter by topic if specified
        if ($test->topic_id) {
            $query->where('topic_id', $test->topic_id);
        }

        // Apply test settings filters
        $settings = $test->settings ?? [];
        
        if (isset($settings['difficulty_levels']) && !empty($settings['difficulty_levels'])) {
            $query->whereIn('difficulty_level', $settings['difficulty_levels']);
        }

        if (isset($settings['question_types']) && !empty($settings['question_types'])) {
            $query->whereIn('type', $settings['question_types']);
        }

        // Apply difficulty distribution if specified
        if (isset($settings['difficulty_distribution'])) {
            return $this->applyDifficultyDistribution($query, $test->total_questions, $settings['difficulty_distribution']);
        }

        // Default: get random questions up to total_questions limit
        $questions = $query->inRandomOrder()
            ->limit($test->total_questions)
            ->get();

        // If no questions found, throw a specific exception
        if ($questions->isEmpty()) {
            throw new Exception("No questions available for this test. Please contact administrator to add questions for chapter: " . ($test->chapter->name ?? 'Unknown'));
        }

        return $questions;
    }

    /**
     * Apply difficulty distribution to question selection
     */
    private function applyDifficultyDistribution($baseQuery, int $totalQuestions, array $distribution): Collection
    {
        $questions = collect();
        
        foreach ($distribution as $difficulty => $percentage) {
            $count = intval(($percentage / 100) * $totalQuestions);
            
            if ($count > 0) {
                $difficultyQuestions = (clone $baseQuery)
                    ->where('difficulty_level', $difficulty)
                    ->inRandomOrder()
                    ->limit($count)
                    ->get();
                
                $questions = $questions->concat($difficultyQuestions);
            }
        }

        // Fill remaining slots if needed
        $remaining = $totalQuestions - $questions->count();
        if ($remaining > 0) {
            $usedIds = $questions->pluck('id')->toArray();
            $remainingQuestions = (clone $baseQuery)
                ->whereNotIn('id', $usedIds)
                ->inRandomOrder()
                ->limit($remaining)
                ->get();
            
            $questions = $questions->concat($remainingQuestions);
        }

        return $questions->take($totalQuestions);
    }

    /**
     * Get user's test progress if exists
     */
    private function getUserTestProgress(int $testId, ?int $userId): ?array
    {
        if (!$userId) {
            return null;
        }

        $attempt = TestAttempt::where('test_id', $testId)
            ->where('user_id', $userId)
            ->whereNull('completed_at') // In progress means completed_at is null
            ->with(['userAnswers'])
            ->first();

        if (!$attempt) {
            return null;
        }

        return [
            'attempt_id' => $attempt->id,
            'started_at' => $attempt->started_at,
            'time_spent' => $attempt->started_at ? now()->diffInSeconds($attempt->started_at) : 0,
            'answered_questions' => $attempt->userAnswers->pluck('question_id')->toArray(),
            'current_question_index' => count($attempt->userAnswers),
        ];
    }

    /**
     * Get question paper metadata
     */
    private function getQuestionPaperMetadata(Test $test, Collection $questions): array
    {
        $questionsByType = $questions->groupBy('type');
        $questionsByDifficulty = $questions->groupBy('difficulty_level');

        return [
            'total_questions' => $questions->count(),
            'total_marks' => $questions->sum('marks'),
            'estimated_duration' => $test->duration ?? $this->estimateDuration($questions),
            'questions_by_type' => $questionsByType->map->count(),
            'questions_by_difficulty' => $questionsByDifficulty->map->count(),
            'chapters_covered' => $questions->pluck('chapter.name')->unique()->values(),
            'topics_covered' => $questions->pluck('topic.name')->filter()->unique()->values(),
        ];
    }

    /**
     * Estimate duration based on questions
     */
    private function estimateDuration(Collection $questions): int
    {
        $totalMinutes = 0;
        
        foreach ($questions as $question) {
            // Estimate time based on question type and difficulty
            $baseTime = match($question->type->value ?? $question->type) {
                'mcq' => 1.5,
                'true_false' => 1,
                'short_answer' => 3,
                'long_answer' => 8,
                'programming' => 15,
                default => 2
            };

            // Adjust for difficulty (assuming numeric values 1-5)
            $difficultyMultiplier = match($question->difficulty_level) {
                1 => 0.8,
                2 => 1.0,
                3 => 1.2,
                4 => 1.5,
                5 => 2.0,
                default => 1.0
            };

            $totalMinutes += $baseTime * $difficultyMultiplier;
        }

        return max(intval($totalMinutes), 10); // Minimum 10 minutes
    }

    /**
     * Get test settings for frontend
     */
    private function getTestSettings(Test $test): array
    {
        return [
            'allow_navigation' => $test->settings['allow_navigation'] ?? true,
            'show_question_numbers' => $test->settings['show_question_numbers'] ?? true,
            'enable_ai_hints' => $test->settings['enable_ai_hints'] ?? true,
            'auto_save_answers' => $test->settings['auto_save_answers'] ?? true,
            'show_progress_bar' => $test->settings['show_progress_bar'] ?? true,
            'allow_review' => $test->settings['allow_review'] ?? true,
            'negative_marking' => $test->negative_marking,
            'negative_marks_per_question' => $test->negative_marks_per_question ?? 0,
            'randomize_options' => $test->settings['randomize_options'] ?? false,
        ];
    }

    /**
     * Build question navigation structure
     */
    private function buildQuestionNavigation(Collection $questions): array
    {
        return $questions->map(function ($question, $index) {
            return [
                'index' => $index + 1,
                'id' => $question->id,
                'type' => $question->type,
                'marks' => $question->marks,
                'difficulty' => $question->difficulty_level,
                'is_answered' => false, // Will be updated by frontend
                'anchor' => "q" . ($index + 1),
            ];
        })->toArray();
    }

    /**
     * Start test attempt for user
     */
    public function startTestAttempt(int $testId, int $userId): TestAttempt
    {
        $test = $this->getTestById($testId);
        
        if (!$test) {
            throw new Exception('Test not found');
        }

        // Check if user has exceeded max attempts
        if ($test->max_attempts) {
            $attemptCount = TestAttempt::where('test_id', $testId)
                ->where('user_id', $userId)
                ->whereNotNull('completed_at') // Use completed_at instead of status
                ->count();

            if ($attemptCount >= $test->max_attempts) {
                throw new Exception('Maximum attempts exceeded');
            }
        }

        // Check for existing in-progress attempt (not completed)
        $existingAttempt = TestAttempt::where('test_id', $testId)
            ->where('user_id', $userId)
            ->whereNull('completed_at') // In progress means completed_at is null
            ->first();

        if ($existingAttempt) {
            return $existingAttempt;
        }

        // Create new attempt
        return TestAttempt::create([
            'test_id' => $testId,
            'user_id' => $userId,
            'started_at' => now(),
            'completed_at' => null, // null means in progress
            'total_questions' => $test->total_questions,
            'correct_answers' => 0,
            'wrong_answers' => 0,
            'skipped_answers' => $test->total_questions, // Initially all are skipped
            'percentage' => 0,
            'time_taken' => 0,
            'obtained_marks' => 0,
            'total_marks' => $test->total_marks,
            'is_passed' => false,
            'attempt_number' => $this->getNextAttemptNumber($testId, $userId),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'answers' => json_encode([]),
            'time_spent_per_question' => json_encode([]),
        ]);
    }

    /**
     * Get next attempt number for user
     */
    private function getNextAttemptNumber(int $testId, int $userId): int
    {
        $lastAttempt = TestAttempt::where('test_id', $testId)
            ->where('user_id', $userId)
            ->orderBy('attempt_number', 'desc')
            ->first();

        return $lastAttempt ? $lastAttempt->attempt_number + 1 : 1;
    }

    /**
     * Save user answer
     */
    public function saveAnswer(int $attemptId, int $questionId, string $answer): UserAnswer
    {
        $attempt = TestAttempt::findOrFail($attemptId);
        $question = Question::findOrFail($questionId);

        // Validate that the attempt belongs to the authenticated user
        if ($attempt->user_id !== auth()->id()) {
            throw new Exception('Unauthorized access to test attempt');
        }

        // Check if answer already exists
        $userAnswer = UserAnswer::where('test_attempt_id', $attemptId)
            ->where('question_id', $questionId)
            ->first();

        $isCorrect = $question->isCorrectAnswer($answer);
        $pointsEarned = $isCorrect ? $question->marks : 0;

        if ($userAnswer) {
            // Update existing answer - increment attempt count
            $userAnswer->update([
                'user_answer' => strtoupper($answer),
                'is_correct' => $isCorrect,
                'points_earned' => $pointsEarned,
                'answered_at' => now(),
                'attempt_count' => $userAnswer->attempt_count + 1,
                'updated_at' => now(),
            ]);
        } else {
            // Create new answer
            $userAnswer = UserAnswer::create([
                'test_attempt_id' => $attemptId,
                'question_id' => $questionId,
                'user_id' => $attempt->user_id,
                'user_answer' => strtoupper($answer),
                'is_correct' => $isCorrect,
                'points_earned' => $pointsEarned,
                'answered_at' => now(),
                'attempt_count' => 1,
                'confidence_level' => 3, // Default confidence level
            ]);

            // Update question usage count
            $question->incrementUsage();
        }

        // Update attempt statistics
        $this->updateAttemptStatistics($attempt);

        return $userAnswer;
    }

    /**
     * Update attempt statistics
     */
    private function updateAttemptStatistics(TestAttempt $attempt): void
    {
        $answers = UserAnswer::where('test_attempt_id', $attempt->id)->get();
        
        $correctAnswers = $answers->where('is_correct', true)->count();
        $wrongAnswers = $answers->where('is_correct', false)->whereNotNull('user_answer')->count();
        $skippedAnswers = $attempt->total_questions - $answers->count();
        
        $obtainedMarks = $answers->sum('points_earned');
        $percentage = $attempt->total_questions > 0 ? ($correctAnswers / $attempt->total_questions) * 100 : 0;

        $attempt->update([
            'correct_answers' => $correctAnswers,
            'wrong_answers' => $wrongAnswers,
            'skipped_answers' => $skippedAnswers,
            'obtained_marks' => $obtainedMarks,
            'percentage' => round($percentage, 2),
        ]);
    }

    /**
     * Submit test attempt
     */
    public function submitTest(int $attemptId): TestAttempt
    {
        $attempt = TestAttempt::findOrFail($attemptId);
        
        if ($attempt->completed_at !== null) {
            throw new Exception('Test already submitted');
        }

        // Calculate final statistics
        $this->updateAttemptStatistics($attempt);
        
        // Calculate time taken
        $timeTaken = $attempt->started_at ? now()->diffInSeconds($attempt->started_at) : 0;
        
        // Calculate if passed
        $passingPercentage = $attempt->test->passing_marks ?? 40;
        $isPassed = $attempt->percentage >= $passingPercentage;
        
        $attempt->update([
            'completed_at' => now(),
            'time_taken' => $timeTaken,
            'is_passed' => $isPassed,
        ]);

        // Update test statistics
        $test = $attempt->test;
        $test->incrementAttempts();
        $test->updateAverageScore();

        // Update question success rates
        $this->updateQuestionSuccessRates($attempt);

        // Clear question paper cache
        $this->clearQuestionPaperCache($attempt->test_id, $attempt->user_id);

        return $attempt->fresh();
    }

    /**
     * Update question success rates
     */
    private function updateQuestionSuccessRates(TestAttempt $attempt): void
    {
        $answers = UserAnswer::where('test_attempt_id', $attempt->id)->get();
        
        foreach ($answers as $answer) {
            $question = Question::find($answer->question_id);
            if ($question) {
                $question->updateSuccessRate();
            }
        }
    }

    /**
     * Get test results
     */
    public function getTestResults(int $attemptId): array
    {
        $attempt = TestAttempt::with(['test', 'userAnswers.question.options'])
            ->findOrFail($attemptId);

        $questions = $attempt->userAnswers->map(function ($userAnswer) {
            $question = $userAnswer->question;
            return [
                'question' => $question,
                'user_answer' => $userAnswer->user_answer,
                'correct_answer' => $question->correct_answer,
                'is_correct' => $userAnswer->is_correct,
                'marks_obtained' => $userAnswer->points_earned,
                'explanation' => $question->explanation,
                'attempt_count' => $userAnswer->attempt_count,
                'confidence_level' => $userAnswer->confidence_level,
            ];
        });

        return [
            'attempt' => $attempt,
            'questions' => $questions,
            'summary' => [
                'total_questions' => $attempt->total_questions,
                'correct_answers' => $attempt->correct_answers,
                'wrong_answers' => $attempt->wrong_answers,
                'unanswered' => $attempt->skipped_answers,
                'score' => $attempt->obtained_marks,
                'percentage' => $attempt->percentage,
                'time_taken' => $attempt->time_taken ?? 0,
                'passed' => $attempt->percentage >= ($attempt->test->passing_marks ?? 40),
            ],
        ];
    }

    /**
     * Clear question paper cache
     */
    public function clearQuestionPaperCache(?int $testId = null, ?int $userId = null): void
    {
        if ($testId && $userId) {
            Cache::forget("question_paper_{$testId}_user_{$userId}");
        } else {
            // Clear all question paper caches (admin function)
            Cache::flush(); // This is a simple approach; in production, you'd want more granular cache clearing
        }
    }

    /**
     * Get available tests for question paper generation
     */
    public function getAvailableTests(?int $chapterId = null): Collection
    {
        $query = Test::where('is_active', true)
            ->where('is_public', true)
            ->with(['chapter']);

        if ($chapterId) {
            $query->where('chapter_id', $chapterId);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    /**
     * Get test preview without starting an attempt
     */
    public function getTestPreview(int $testId): array
    {
        $test = $this->getTestById($testId);
        
        if (!$test) {
            throw new Exception('Test not found');
        }

        return [
            'test' => $test,
            'metadata' => [
                'total_questions' => $test->total_questions,
                'total_marks' => $test->total_marks,
                'duration' => $test->duration,
                'type' => $test->type,
                'difficulty_info' => $this->getTestDifficultyInfo($test),
            ],
            'instructions' => $test->instructions,
            'settings' => $this->getTestSettings($test),
        ];
    }

    /**
     * Get test difficulty information
     */
    private function getTestDifficultyInfo(Test $test): array
    {
        if (!empty($test->question_ids)) {
            $questions = Question::whereIn('id', $test->question_ids)->get();
            $difficultyDistribution = $questions->groupBy('difficulty_level')->map->count();
        } else {
            $difficultyDistribution = $test->settings['difficulty_distribution'] ?? [];
        }

        return [
            'distribution' => $difficultyDistribution,
            'average_difficulty' => $this->calculateAverageDifficulty($difficultyDistribution),
        ];
    }

    /**
     * Calculate average difficulty
     */
    private function calculateAverageDifficulty(array $distribution): string
    {
        if (empty($distribution)) {
            return 'মাঝারি';
        }

        $totalQuestions = array_sum($distribution);
        $weightedSum = 0;

        foreach ($distribution as $level => $count) {
            $weightedSum += $level * $count;
        }

        $average = $totalQuestions > 0 ? $weightedSum / $totalQuestions : 3;

        return match(round($average)) {
            1 => 'খুব সহজ',
            2 => 'সহজ',
            3 => 'মাঝারি',
            4 => 'কঠিন',
            5 => 'খুব কঠিন',
            default => 'মাঝারি'
        };
    }
}