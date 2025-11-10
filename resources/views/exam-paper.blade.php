@extends('layouts.app')

@section('title', '{{ $questionPaper["test"]->title }} - HSC ICT Interactive')
@section('description', '{{ $questionPaper["test"]->description ?? "HSC ICT মডেল টেস্ট দিন এবং পরীক্ষার জন্য প্রস্তুতি নিন।" }}')
@section('keywords', 'HSC ICT মডেল টেস্ট, পরীক্ষা প্রস্তুতি, বোর্ড প্রশ্ন, MCQ, বাংলাদেশ, শিক্ষা')

{{-- Open Graph Meta Tags --}}
<meta property="og:title" content="{{ $questionPaper['test']->title }} - HSC ICT Interactive"/>
<meta property="og:description" content="{{ $questionPaper['test']->description ?? 'HSC ICT মডেল টেস্ট দিন এবং পরীক্ষার জন্য প্রস্তুতি নিন।' }}"/>
<meta property="og:type" content="website"/>
<meta property="og:url" content="{{ request()->fullUrl() }}"/>
<meta property="og:image" content="https://hscict.com/images/exam-og-image.jpg"/>
<meta property="og:image:alt" content="HSC ICT Interactive - মডেল টেস্ট পেজ"/>
<meta property="og:site_name" content="HSC ICT Interactive"/>
<meta property="og:locale" content="bn_BD"/>

{{-- Twitter Card Meta Tags --}}
<meta name="twitter:card" content="summary_large_image"/>
<meta name="twitter:title" content="{{ $questionPaper['test']->title }} - HSC ICT Interactive"/>
<meta name="twitter:description" content="{{ $questionPaper['test']->description ?? 'HSC ICT মডেল টেস্ট দিন এবং পরীক্ষার জন্য প্রস্তুতি নিন।' }}"/>
<meta name="twitter:image" content="https://hscict.com/images/exam-og-image.jpg"/>
<meta name="twitter:image:alt" content="HSC ICT Interactive - মডেল টেস্ট পেজ"/>

@section('header-extra')
<!-- Custom exam header with exit button -->
<div class="flex items-center gap-2">
    <button @click="exitExam()" class="flex cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-red-500/10 hover:bg-red-500/20 text-red-600 dark:text-red-400 transition-colors gap-2 bengali-text">
        <span class="material-symbols-outlined text-xl">logout</span>
        <span class="hidden md:inline text-sm font-bold">পরীক্ষা ত্যাগ করুন</span>
    </button>
</div>
@endsection

@section('content')
<div x-data="examApp()" x-init="initializeExam()">

<!-- Exam Info & Timer Bar -->
<div class="sticky top-[61px] z-40 bg-white/80 dark:bg-slate-900/80 backdrop-blur-sm border-b border-primary/20">
<div class="max-w-6xl mx-auto px-4 py-3">
<div class="flex flex-col md:flex-row items-center justify-between gap-4">
<div class="flex-1 text-center md:text-left">
<p class="text-sm font-semibold text-[#0d1b18] dark:text-white bengali-text">
  @if($questionPaper['test']->chapter)
    {{ $questionPaper['test']->chapter->name }}
  @else
    {{ $questionPaper['test']->title }}
  @endif
</p>
<p class="text-xs text-slate-600 dark:text-slate-400 bengali-text">{{ $questionPaper['test']->title }}</p>
</div>
<div class="flex items-center gap-3 px-4 py-2 rounded-lg bg-primary/10">
<span class="material-symbols-outlined text-xl text-primary">timer</span>
<div class="text-center">
<p class="text-xs text-slate-600 dark:text-slate-400 bengali-text">সময় বাকি</p>
<p class="font-bold text-[#0d1b18] dark:text-white text-lg" 
   x-text="formatTime(timeLeft)"
   :class="{ 'text-red-600': timeLeft <= 300, 'text-yellow-600': timeLeft > 300 && timeLeft <= 600 }">
</p>
</div>
</div>
<div class="flex items-center gap-3">
<div class="text-center px-3">
<p class="text-xs text-slate-600 dark:text-slate-400 bengali-text">মোট প্রশ্ন</p>
<p class="text-lg font-bold text-[#0d1b18] dark:text-white bengali-text">{{ $questionPaper['metadata']['total_questions'] }}</p>
</div>
              <button @click="submitExam()" class="flex h-10 cursor-pointer items-center justify-center gap-2 rounded-lg bg-green-500 px-6 text-sm font-bold text-white shadow-md hover:bg-green-600 transition-colors bengali-text">
                <span>জমা দিন</span>
                <span class="material-symbols-outlined text-lg">check_circle</span>
              </button>
</div>
</div>
</div>
</div>

<!-- MAIN CONTENT -->
<main class="flex-grow">
<div class="max-w-7xl mx-auto px-4 py-6">
<div class="grid grid-cols-12 gap-6">
<!-- Left Sidebar - Question Navigation -->
<aside class="col-span-12 lg:col-span-2">
<div class="sticky top-40">
<div class="mb-4 flex items-center justify-between">
<h3 class="text-sm font-bold uppercase text-slate-500 dark:text-slate-400 bengali-text">প্রশ্নসমূহ</h3>
</div>
                <div class="grid grid-cols-5 lg:grid-cols-3 gap-2">
                @foreach($questionPaper['navigation'] as $nav)
                  <button @click="goToQuestion({{ $nav['index'] }})" 
                     class="flex h-10 w-10 items-center justify-center rounded-lg font-medium transition-all hover:scale-105"
                     :class="{
                       'bg-primary text-white': currentQuestionIndex === {{ $nav['index'] - 1 }},
                       'bg-green-500/20 text-green-600 border border-green-500/30': answeredQuestions.has({{ $nav['id'] }}) && currentQuestionIndex !== {{ $nav['index'] - 1 }},
                       'bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:border-primary hover:bg-primary/5': !answeredQuestions.has({{ $nav['id'] }}) && currentQuestionIndex !== {{ $nav['index'] - 1 }}
                     }">
                    {{ $nav['index'] }}
                  </button>
                @endforeach
                </div>
<!-- Legend -->
<div class="mt-6 space-y-2 text-xs">
<div class="flex items-center gap-2">
<div class="w-4 h-4 rounded bg-primary"></div>
<span class="text-slate-600 dark:text-slate-400 bengali-text">বর্তমান</span>
</div>
<div class="flex items-center gap-2">
<div class="w-4 h-4 rounded bg-green-500/20 border border-green-500/30"></div>
<span class="text-slate-600 dark:text-slate-400 bengali-text">উত্তরিত</span>
</div>
<div class="flex items-center gap-2">
<div class="w-4 h-4 rounded bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700"></div>
<span class="text-slate-600 dark:text-slate-400 bengali-text">অনুত্তরিত</span>
</div>
</div>
</div>
</aside>

            <!-- Right Column - Questions List -->
            <div class="col-span-12 lg:col-span-10">
                <div class="space-y-6" id="questions-container">

                @foreach($questionPaper['questions'] as $index => $question)
                <!-- Question Block {{ $index + 1 }} -->
                <div class="rounded-xl border @if($index === 0) border-primary/30 @else border-slate-200 dark:border-slate-700 @endif bg-white dark:bg-slate-900/50 p-6 @if($index === 0) shadow-md @endif question-block" 
                     x-ref="question_{{ $index + 1 }}"
                     data-question-id="{{ $question->id }}"
                     data-question-index="{{ $index + 1 }}">
                
                <div class="flex items-start justify-between gap-4 mb-4">
                <div class="flex-1">
                <p class="text-lg text-[#0d1b18] dark:text-white mb-2 bengali-text">
                <strong class="font-bold">প্রশ্ন {{ $index + 1 }}:</strong> {{ $question->question }}
                </p>
                <div class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                <span class="material-symbols-outlined text-base">grade</span>
                <span class="bengali-text">মান: {{ $question->marks }}</span>
                @if($question->difficulty_level)
                  <span class="px-2 py-1 rounded-full text-xs 
                    @php
                      $level = is_object($question->difficulty_level) ? $question->difficulty_level->level() : $question->difficulty_level;
                    @endphp
                    @if($level === 1) bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300
                    @elseif($level === 2) bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-300
                    @elseif($level === 3) bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-300
                    @elseif($level === 4) bg-orange-100 text-orange-800 dark:bg-orange-900/20 dark:text-orange-300
                    @else bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-300 @endif">
                    {{ $question->difficulty_text }}
                  </span>
                @endif
                </div>
                </div>
                
                @if(in_array($question->type->value ?? $question->type, ['programming', 'long_answer']))
                <button class="flex shrink-0 h-10 cursor-pointer items-center justify-center gap-2 rounded-lg bg-blue-500 hover:bg-blue-600 px-4 text-sm font-bold text-white transition-all shadow-md bengali-text">
                <span class="material-symbols-outlined text-lg">
                  @if(($question->type->value ?? $question->type) === 'programming') code @else edit_note @endif
                </span>
                <span>
                  @if(($question->type->value ?? $question->type) === 'programming') এডিটর খুলুন @else লিখুন @endif
                </span>
                </button>
                @endif
                </div>

                <!-- Question Content -->
                <div class="question-content mb-4 relative">
                @if(($question->type->value ?? $question->type) === 'mcq' && $question->options->isNotEmpty())
                  <!-- Auto-save indicator for MCQ -->
                  <div x-show="saveIndicators[{{ $question->id }}]" 
                       x-transition
                       class="absolute top-0 right-0 z-10 flex items-center gap-1 bg-green-500 text-white px-2 py-1 rounded-md text-xs font-medium">
                    <span class="material-symbols-outlined text-sm">check_circle</span>
                    <span>সংরক্ষিত</span>
                  </div>
                  <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                  @foreach($question->options as $option)
                    <label class="flex items-center gap-3 rounded-lg border border-slate-200 dark:border-slate-700 p-4 has-[:checked]:bg-primary/10 has-[:checked]:border-primary cursor-pointer transition-all hover:border-primary/50">
                    <input class="h-4 w-4 text-primary focus:ring-primary focus:ring-2 question-option" 
                           name="q{{ $index + 1 }}" 
                           type="radio"
                           value="{{ $option->option_key }}"
                           data-question-id="{{ $question->id }}"
                           @change="saveAnswer($event.target, {{ $question->id }})"/>
                    <span class="bengali-text">{{ $option->option_text }}</span>
                    </label>
                  @endforeach
                  </div>
                @elseif(($question->type->value ?? $question->type) === 'true_false')
                  <!-- Auto-save indicator for True/False -->
                  <div x-show="saveIndicators[{{ $question->id }}]" 
                       x-transition
                       class="absolute top-0 right-0 z-10 flex items-center gap-1 bg-green-500 text-white px-2 py-1 rounded-md text-xs font-medium">
                    <span class="material-symbols-outlined text-sm">check_circle</span>
                    <span>সংরক্ষিত</span>
                  </div>
                  <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <label class="flex items-center gap-3 rounded-lg border border-slate-200 dark:border-slate-700 p-4 has-[:checked]:bg-primary/10 has-[:checked]:border-primary cursor-pointer transition-all hover:border-primary/50">
                    <input class="h-4 w-4 text-primary focus:ring-primary focus:ring-2 question-option" 
                           name="q{{ $index + 1 }}" 
                           type="radio"
                           value="true"
                           data-question-id="{{ $question->id }}"
                           @change="saveAnswer($event.target, {{ $question->id }})"/>
                    <span class="bengali-text">সত্য</span>
                    </label>
                    <label class="flex items-center gap-3 rounded-lg border border-slate-200 dark:border-slate-700 p-4 has-[:checked]:bg-primary/10 has-[:checked]:border-primary cursor-pointer transition-all hover:border-primary/50">
                    <input class="h-4 w-4 text-primary focus:ring-primary focus:ring-2 question-option" 
                           name="q{{ $index + 1 }}" 
                           type="radio"
                           value="false"
                           data-question-id="{{ $question->id }}"
                           @change="saveAnswer($event.target, {{ $question->id }})"/>
                    <span class="bengali-text">মিথ্যা</span>
                    </label>
                  </div>
                @else
                  <div class="relative">
                    <textarea 
                      class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-[#0d1b18] dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all bengali-text question-textarea" 
                      placeholder="আপনার উত্তর লিখুন..."
                      data-question-id="{{ $question->id }}"
                      @change="saveAnswer($event.target, {{ $question->id }})"
                      @input="handleAutoSaveInput($event, {{ $question->id }})"
                      rows="{{ ($question->type->value ?? $question->type) === 'long_answer' ? '6' : '3' }}"></textarea>
                    
                    <!-- Auto-save indicator -->
                    <div x-show="saveIndicators[{{ $question->id }}]" 
                         x-transition
                         class="absolute top-2 right-2 flex items-center gap-1 bg-green-500 text-white px-2 py-1 rounded-md text-xs font-medium">
                      <span class="material-symbols-outlined text-sm">check_circle</span>
                      <span>সংরক্ষিত</span>
                    </div>
                  </div>
                @endif
                </div>

                <!-- AI Hint Toggle - Always show, enabled by settings -->
                <div class="mt-4 pt-4 border-t border-slate-200 dark:border-slate-700">
                <button @click="toggleAIHint({{ $question->id }})" 
                        class="flex items-center gap-2 text-sm font-medium text-primary hover:text-primary/80 transition-colors bengali-text"
                        :disabled="!settings.enable_ai_hints" :title="!settings.enable_ai_hints ? 'AI সাহায্য এই পরীক্ষার জন্য নিষ্ক্রিয় করা হয়েছে' : ''">
                <span class="material-symbols-outlined text-lg">psychology</span>
                <span>AI সাহায্য চাই</span>
                </button>
                <!-- AI Hint Panel -->
                <div x-show="aiHints[{{ $question->id }}]" x-transition class="mt-3">
                <div class="rounded-lg bg-gradient-to-br from-purple-50 to-blue-50 dark:from-purple-900/20 dark:to-blue-900/20 border border-purple-200 dark:border-purple-700/30 p-4">
                <div class="flex items-start gap-3">
                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center">
                <span class="material-symbols-outlined text-white text-lg">smart_toy</span>
                </div>
                <div class="flex-1">
                <p class="text-sm font-bold text-purple-900 dark:text-purple-200 mb-2 bengali-text">AI হিন্ট</p>
                <div class="text-sm text-slate-700 dark:text-slate-300 space-y-2 bengali-text ai-hint-content">
                  @if($question->explanation)
                    {{ $question->explanation }}
                  @else
                    <div class="flex items-center gap-2 text-slate-500 dark:text-slate-400">
                      <span class="material-symbols-outlined animate-spin text-lg">refresh</span>
                      <span>AI হিন্ট তৈরি করা হচ্ছে...</span>
                    </div>
                  @endif
                </div>
                </div>
                </div>
                </div>
                </div>
                </div>
                </div>
                @endforeach

                </div>

</div>

<!-- Navigation Buttons -->
<div class="flex items-center justify-between mt-8 pt-6 border-t border-slate-200 dark:border-slate-700">
<button class="flex h-11 cursor-pointer items-center justify-center gap-2 rounded-lg bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700 px-6 text-sm font-bold text-[#0d1b18] dark:text-white transition-all bengali-text" disabled>
<span class="material-symbols-outlined text-lg">arrow_back</span>
<span>পূর্ববর্তী</span>
</button>
<button class="flex h-11 cursor-pointer items-center justify-center gap-2 rounded-lg bg-primary hover:bg-opacity-90 px-6 text-sm font-bold text-[#0d1b18] transition-all shadow-md bengali-text">
<span>পরবর্তী</span>
<span class="material-symbols-outlined text-lg">arrow_forward</span>
</button>
</div>
</div>
</div>
</div>
</main>

</div> <!-- End Alpine.js component -->
@endsection

@push('scripts')
<script>
function examApp() {
  return {
    // Test data from backend
    testId: {{ $questionPaper['test']->id }},
    attemptId: {{ $questionPaper['user_progress']['attempt_id'] ?? 'null' }},
    totalQuestions: {{ $questionPaper['metadata']['total_questions'] }},
    timeLimit: {{ $questionPaper['metadata']['estimated_duration'] * 60 }},
    settings: @json($questionPaper['settings']),
    
    // State variables
    timeLeft: {{ $questionPaper['metadata']['estimated_duration'] * 60 }},
    currentQuestionIndex: {{ $questionPaper['user_progress']['current_question_index'] ?? 0 }},
    answeredQuestions: new Set(@json($questionPaper['user_progress']['answered_questions'] ?? []))),
    aiHints: {},
    timerInterval: null,
    autoSaveTimeouts: {},
    saveIndicators: {},
    
    // Initialize exam
    initializeExam() {
      if (this.timeLeft > 0) {
        this.timerInterval = setInterval(() => {
          this.updateTimer();
        }, 1000);
      }
      
      if (this.settings.auto_save_answers) {
        this.setupAutoSave();
      }
    },
    
    // Format time display
    formatTime(seconds) {
      const minutes = Math.floor(seconds / 60);
      const secs = seconds % 60;
      return `${minutes}:${secs.toString().padStart(2, '0')}`;
    },
    
    // Update timer
    updateTimer() {
      if (this.timeLeft > 0) {
        this.timeLeft--;
      } else {
        clearInterval(this.timerInterval);
        alert('সময় শেষ! আপনার উত্তরপত্র স্বয়ংক্রিয়ভাবে জমা দেওয়া হচ্ছে।');
        this.submitExam();
      }
    },
    
    // Go to specific question
    goToQuestion(questionIndex) {
      this.currentQuestionIndex = questionIndex - 1;
      
      // Use Alpine.js to scroll to question
      this.$nextTick(() => {
        this.$refs[`question_${questionIndex}`]?.scrollIntoView({ 
          behavior: 'smooth', 
          block: 'start' 
        });
      });
    },
    
    // Save answer
    async saveAnswer(element, questionId) {
      if (!this.attemptId) {
        alert('পরীক্ষা শুরু করুন প্রথমে');
        return;
      }

      let answer = '';
      if (element.type === 'radio') {
        answer = element.value;
      } else if (element.tagName.toLowerCase() === 'textarea') {
        answer = element.value.trim();
      }

      if (!answer) {
        return;
      }

      try {
        const response = await fetch('{{ route('tests.save-answer') }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
          },
          body: JSON.stringify({
            attempt_id: this.attemptId,
            question_id: questionId,
            answer: answer
          })
        });

        const result = await response.json();
        
        if (result.success) {
          this.answeredQuestions.add(questionId);
          
          // Show save indicator if needed
          if (this.settings.auto_save_answers) {
            this.showSaveIndicator(element);
          }
        } else {
          console.error('Failed to save answer:', result.message);
        }
      } catch (error) {
        console.error('Error saving answer:', error);
      }
    },
    
    // Show save indicator
    showSaveIndicator(element) {
      const questionId = parseInt(element.dataset.questionId);
      this.saveIndicators[questionId] = true;
      
      setTimeout(() => {
        this.saveIndicators[questionId] = false;
      }, 2000);
    },
    
    // Setup auto-save functionality using Alpine.js reactive data
    setupAutoSave() {
      // Auto-save will be handled by @input events directly in the template
      // No need for DOM manipulation here
    },
    
    // Handle auto-save input
    handleAutoSaveInput(event, questionId) {
      if (!this.settings.auto_save_answers) return;
      
      clearTimeout(this.autoSaveTimeouts[questionId]);
      this.autoSaveTimeouts[questionId] = setTimeout(() => {
        if (event.target.value.trim()) {
          this.saveAnswer(event.target, questionId);
        }
      }, 1000);
    },
    
    // Toggle AI hint
    async toggleAIHint(questionId) {
      if (!this.settings.enable_ai_hints) return;
      
      this.aiHints[questionId] = !this.aiHints[questionId];
      
      // Generate hint if showing for first time
      if (this.aiHints[questionId] && !this.aiHintContent[questionId]) {
        await this.generateAIHint(questionId);
      }
    },
    
    // Generate AI hint
    async generateAIHint(questionId) {
      if (!this.settings.enable_ai_hints) return;

      try {
        const response = await fetch('/api/questions/' + questionId + '/ai-hint', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
          },
          body: JSON.stringify({
            context: 'exam',
            test_id: this.testId
          })
        });

        const result = await response.json();
        
        if (result.success && result.hint) {
          this.aiHintContent[questionId] = result.hint;
        }
      } catch (error) {
        console.error('Error generating AI hint:', error);
      }
    },
    
    // Exit exam
    exitExam() {
      const confirmExit = confirm('আপনি কি সত্যিই পরীক্ষা ত্যাগ করতে চান? আপনার সমস্ত উত্তর হারিয়ে যাবে।');
      if (confirmExit) {
        window.location.href = '{{ route('model-tests') }}';
      }
    },
    
    // Submit exam
    async submitExam() {
      const confirmSubmit = confirm('আপনি কি পরীক্ষা জমা দিতে চান? জমা দেওয়ার পর আপনি উত্তর পরিবর্তন করতে পারবেন না।');
      if (!confirmSubmit) {
        return;
      }

      if (!this.attemptId) {
        alert('পরীক্ষা শুরু করুন প্রথমে');
        return;
      }

      try {
        const response = await fetch(`/tests/attempts/${this.attemptId}/submit`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
          }
        });

        const result = await response.json();
        
        if (result.success) {
          window.location.href = result.redirect_url || '/tests/attempts/' + this.attemptId + '/results';
        } else {
          alert('জমা দিতে সমস্যা হয়েছে: ' + result.message);
        }
      } catch (error) {
        console.error('Error submitting exam:', error);
        alert('জমা দিতে সমস্যা হয়েছে। আবার চেষ্টা করুন।');
      }
    }
  }
}
</script>
@endpush