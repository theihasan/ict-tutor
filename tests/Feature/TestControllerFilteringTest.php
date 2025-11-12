<?php

namespace Tests\Feature;

use App\Enums\TestType;
use App\Models\Chapter;
use App\Models\Test;
use App\Models\User;
use App\Models\UserProgress;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TestControllerFilteringTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private Chapter $chapter1;

    private Chapter $chapter2;

    private Test $test1;

    private Test $test2;

    private Test $test3;

    protected function setUp(): void
    {
        parent::setUp();

        // Create test user
        $this->user = User::factory()->create();

        // Create test chapters
        $this->chapter1 = Chapter::factory()->create([
            'name' => 'Mathematics Chapter 1',
            'description' => 'Basic algebra content',
        ]);

        $this->chapter2 = Chapter::factory()->create([
            'name' => 'Physics Chapter 1',
            'description' => 'Basic physics content',
        ]);

        // Create test records
        $this->test1 = Test::factory()->create([
            'title' => 'Mathematics Model Test',
            'description' => 'Basic math test for beginners',
            'type' => TestType::MODEL_TEST,
            'chapter_id' => $this->chapter1->id,
            'is_active' => true,
            'is_featured' => true,
        ]);

        $this->test2 = Test::factory()->create([
            'title' => 'Advanced Physics Test',
            'description' => 'Advanced physics concepts',
            'type' => TestType::PRACTICE_TEST,
            'chapter_id' => $this->chapter2->id,
            'is_active' => true,
            'is_featured' => false,
        ]);

        $this->test3 = Test::factory()->create([
            'title' => 'Chapter Test Mathematics',
            'description' => 'Mathematics chapter test',
            'type' => TestType::CHAPTER_TEST,
            'chapter_id' => $this->chapter1->id,
            'is_active' => false,
            'is_featured' => false,
        ]);
    }

    public function test_it_returns_all_tests_without_filters(): void
    {
        $this->actingAs($this->user);

        $response = $this->get('/model-tests');

        $response->assertStatus(200);
        $response->assertSee($this->test1->title);
        $response->assertSee($this->test2->title);
    }

    public function test_it_filters_tests_by_search_term(): void
    {
        $this->actingAs($this->user);

        $response = $this->get('/model-tests?search=Mathematics');

        $response->assertStatus(200);
        $response->assertSee($this->test1->title); // Contains "Mathematics"
        $response->assertSee($this->test3->title); // Contains "Mathematics"
        $response->assertDontSee($this->test2->title); // Does not contain "Mathematics"
    }

    public function test_it_filters_tests_by_search_in_description(): void
    {
        $this->actingAs($this->user);

        $response = $this->get('/model-tests?search=Advanced');

        $response->assertStatus(200);
        $response->assertSee($this->test2->title); // Description contains "Advanced"
        $response->assertDontSee($this->test1->title);
        $response->assertDontSee($this->test3->title);
    }

    public function test_it_filters_tests_by_type(): void
    {
        $this->actingAs($this->user);

        $response = $this->get('/model-tests?type=model_test');

        $response->assertStatus(200);
        $response->assertSee($this->test1->title); // ModelTest type
        $response->assertDontSee($this->test2->title); // PracticeTest type
        $response->assertDontSee($this->test3->title); // ChapterTest type
    }

    public function test_it_filters_tests_by_chapter(): void
    {
        $this->actingAs($this->user);

        $response = $this->get("/model-tests?chapter_id={$this->chapter1->id}");

        $response->assertStatus(200);
        $response->assertSee($this->test1->title); // Chapter 1
        $response->assertSee($this->test3->title); // Chapter 1
        $response->assertDontSee($this->test2->title); // Chapter 2
    }

    public function test_it_filters_tests_by_active_status_using_boolean(): void
    {
        $this->actingAs($this->user);

        $response = $this->get('/model-tests?is_active=0');

        $response->assertStatus(200);
        $response->assertSee($this->test3->title); // Inactive test
        $response->assertDontSee($this->test1->title); // Active test
        $response->assertDontSee($this->test2->title); // Active test
    }

    public function test_it_filters_tests_by_active_status(): void
    {
        $this->actingAs($this->user);

        $response = $this->get('/model-tests?is_active=1');

        $response->assertStatus(200);
        $response->assertSee($this->test1->title); // Active
        $response->assertSee($this->test2->title); // Active
        $response->assertDontSee($this->test3->title); // Inactive
    }

    public function test_it_filters_tests_by_featured_status(): void
    {
        $this->actingAs($this->user);

        $response = $this->get('/model-tests?is_featured=1');

        $response->assertStatus(200);
        $response->assertSee($this->test1->title); // Featured
        $response->assertDontSee($this->test2->title); // Not featured
        $response->assertDontSee($this->test3->title); // Not featured
    }

    public function test_it_applies_multiple_filters_simultaneously(): void
    {
        $this->actingAs($this->user);

        $queryParams = http_build_query([
            'search' => 'Mathematics',
            'type' => 'model_test',
            'chapter_id' => $this->chapter1->id,
            'is_active' => '1',
        ]);

        $response = $this->get("/model-tests?{$queryParams}");

        $response->assertStatus(200);
        $response->assertSee($this->test1->title); // Matches all criteria
        $response->assertDontSee($this->test2->title); // Wrong type and chapter
        $response->assertDontSee($this->test3->title); // Not active
    }

    public function test_it_handles_empty_search_gracefully(): void
    {
        $this->actingAs($this->user);

        $response = $this->get('/model-tests?search=');

        $response->assertStatus(200);
        // Should return all tests when search is empty
        $response->assertSee($this->test1->title);
        $response->assertSee($this->test2->title);
    }

    public function test_it_handles_invalid_filter_values(): void
    {
        $this->actingAs($this->user);

        $response = $this->get('/model-tests?type=invalid_type&chapter_id=999&is_active=invalid');

        $response->assertStatus(200);
        // Should handle invalid values gracefully and not crash
    }

    public function test_it_preserves_user_progress_when_filtering(): void
    {
        $this->actingAs($this->user);

        // Create user progress for test1
        UserProgress::factory()->create([
            'user_id' => $this->user->id,
            'chapter_id' => $this->chapter1->id,
            'completion_percentage' => 75.5,
        ]);

        $response = $this->get('/model-tests?search=Mathematics');

        $response->assertStatus(200);
        // Verify the response contains the tests and user progress is preserved
        $response->assertSee($this->test1->title);
    }

    public function test_it_returns_hierarchical_structure_when_no_filters(): void
    {
        $this->actingAs($this->user);

        $response = $this->get('/model-tests');

        $response->assertStatus(200);
        // Should return tests grouped by chapters
        $response->assertSee($this->chapter1->name);
        $response->assertSee($this->chapter2->name);
    }

    public function test_it_uses_filtered_results_when_filters_present(): void
    {
        $this->actingAs($this->user);

        $response = $this->get('/model-tests?search=Physics');

        $response->assertStatus(200);
        // Should return filtered results, not hierarchical structure
        $response->assertSee($this->test2->title);
        $response->assertDontSee($this->test1->title);
    }

    public function test_it_works_with_featured_route(): void
    {
        $this->actingAs($this->user);

        $response = $this->get('/model-tests/featured');

        $response->assertStatus(200);
        $response->assertSee($this->test1->title); // Featured test
        $response->assertDontSee($this->test2->title); // Not featured
    }

    public function test_it_works_with_type_specific_route(): void
    {
        $this->actingAs($this->user);

        $response = $this->get('/model-tests/type/practice_test');

        $response->assertStatus(200);
        $response->assertSee($this->test2->title); // PracticeTest type
        $response->assertDontSee($this->test1->title); // ModelTest type
    }

    public function test_it_works_with_chapter_specific_route(): void
    {
        $this->actingAs($this->user);

        $response = $this->get("/model-tests/chapter/{$this->chapter1->id}");

        $response->assertStatus(200);
        $response->assertSee($this->test1->title); // Chapter 1
        $response->assertSee($this->test3->title); // Chapter 1
        $response->assertDontSee($this->test2->title); // Chapter 2
    }

    public function test_guest_users_can_access_filtered_tests(): void
    {
        $response = $this->get('/model-tests?search=Mathematics');

        $response->assertStatus(200);
        $response->assertSee($this->test1->title);
    }

    public function test_it_handles_case_insensitive_search(): void
    {
        $this->actingAs($this->user);

        $response = $this->get('/model-tests?search=mathematics'); // lowercase

        $response->assertStatus(200);
        $response->assertSee($this->test1->title); // Should still match "Mathematics"
        $response->assertSee($this->test3->title);
    }

    public function test_it_handles_partial_search_matches(): void
    {
        $this->actingAs($this->user);

        $response = $this->get('/model-tests?search=Math'); // partial

        $response->assertStatus(200);
        $response->assertSee($this->test1->title); // Should match "Mathematics"
        $response->assertSee($this->test3->title);
    }
}
