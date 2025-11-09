<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProgress;
use App\Models\TestAttempt;
use App\Models\Leaderboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the student dashboard.
     * If no user ID is provided, show the authenticated user's dashboard.
     * If a user ID is provided, show that user's dashboard (with proper authorization).
     */
    public function show(Request $request, $userId = null)
    {
        // If no user ID provided, use authenticated user
        if ($userId === null) {
            $user = Auth::user();
            if (!$user) {
                return redirect()->route('login');
            }
        } else {
            // Find the specified user
            $user = User::findOrFail($userId);
            
            // Authorization check: Only allow users to view their own dashboard
            // or admins to view any dashboard
            if (Auth::id() !== (int)$userId && !Auth::user()->isAdmin()) {
                abort(403, 'Unauthorized to view this dashboard');
            }
        }

        // Get user statistics
        $userStats = $this->getUserStats($user);
        
        // Get recent test attempts
        $recentAttempts = $this->getRecentAttempts($user);
        
        // Get progress data
        $progressData = $this->getProgressData($user);
        
        // Get leaderboard position
        $leaderboardPosition = $this->getLeaderboardPosition($user);

        return view('student-dashboard', compact(
            'user',
            'userStats',
            'recentAttempts',
            'progressData',
            'leaderboardPosition'
        ));
    }

    /**
     * Get user statistics
     */
    private function getUserStats(User $user)
    {
        $totalAttempts = TestAttempt::where('user_id', $user->id)->count();
        $completedTests = TestAttempt::where('user_id', $user->id)
            ->whereNotNull('completed_at')
            ->count();
        
        $averageScore = TestAttempt::where('user_id', $user->id)
            ->whereNotNull('completed_at')
            ->avg('score');

        $streak = $this->calculateStreak($user);

        return [
            'total_attempts' => $totalAttempts,
            'completed_tests' => $completedTests,
            'average_score' => round($averageScore ?? 0, 1),
            'current_streak' => $streak,
            'total_questions_answered' => $this->getTotalQuestionsAnswered($user),
        ];
    }

    /**
     * Get recent test attempts
     */
    private function getRecentAttempts(User $user)
    {
        return TestAttempt::with('test')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
    }

    /**
     * Get progress data for topics/chapters
     */
    private function getProgressData(User $user)
    {
        return UserProgress::with('topic')
            ->where('user_id', $user->id)
            ->orderBy('updated_at', 'desc')
            ->limit(10)
            ->get();
    }

    /**
     * Get user's position on leaderboard
     */
    private function getLeaderboardPosition(User $user)
    {
        return Leaderboard::where('user_id', $user->id)->first();
    }

    /**
     * Calculate user's current streak
     */
    private function calculateStreak(User $user)
    {
        $attempts = TestAttempt::where('user_id', $user->id)
            ->whereNotNull('completed_at')
            ->orderBy('completed_at', 'desc')
            ->get();

        $streak = 0;
        $lastDate = null;

        foreach ($attempts as $attempt) {
            $attemptDate = $attempt->completed_at->format('Y-m-d');
            
            if ($lastDate === null) {
                $streak = 1;
                $lastDate = $attemptDate;
            } elseif ($lastDate === $attemptDate) {
                // Same day, continue
                continue;
            } elseif (strtotime($lastDate) - strtotime($attemptDate) === 86400) {
                // Consecutive day
                $streak++;
                $lastDate = $attemptDate;
            } else {
                // Gap in streak
                break;
            }
        }

        return $streak;
    }

    /**
     * Get total questions answered by user
     */
    private function getTotalQuestionsAnswered(User $user)
    {
        return DB::table('user_answers')
            ->join('test_attempts', 'user_answers.test_attempt_id', '=', 'test_attempts.id')
            ->where('test_attempts.user_id', $user->id)
            ->count();
    }
}