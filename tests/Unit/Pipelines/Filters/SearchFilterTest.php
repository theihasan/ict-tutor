<?php

namespace Tests\Unit\Pipelines\Filters;

use App\Models\Chapter;
use App\Models\Faq;
use App\Models\Question;
use App\Models\Test;
use App\Pipelines\Filters\SearchFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use ReflectionClass;
use Tests\TestCase;

class SearchFilterTest extends TestCase
{
    use RefreshDatabase;

    private SearchFilter $filter;

    protected function setUp(): void
    {
        parent::setUp();
        $this->filter = new SearchFilter;
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /**
     * Helper method to call protected applyFilter method
     */
    private function callApplyFilter(Builder $query, mixed $value): Builder
    {
        $reflection = new ReflectionClass($this->filter);
        $method = $reflection->getMethod('applyFilter');
        $method->setAccessible(true);

        return $method->invoke($this->filter, $query, $value);
    }

    public function test_it_applies_search_filter_to_tests_model(): void
    {
        $query = Test::query();
        $searchTerm = 'mathematics';

        $result = $this->callApplyFilter($query, $searchTerm);

        $this->assertInstanceOf(Builder::class, $result);

        // Test SQL contains the expected LIKE conditions
        $sql = $result->toSql();
        $this->assertStringContainsString('title', $sql);
        $this->assertStringContainsString('description', $sql);
        $this->assertStringContainsString('LIKE', $sql);

        // Test bindings contain the search term
        $bindings = $result->getBindings();
        $this->assertContains("%{$searchTerm}%", $bindings);
    }

    public function test_it_applies_search_filter_to_chapters_model(): void
    {
        $query = Chapter::query();
        $searchTerm = 'algebra';

        $result = $this->callApplyFilter($query, $searchTerm);

        $sql = $result->toSql();
        $this->assertStringContainsString('title', $sql);
        $this->assertStringContainsString('content', $sql);

        $bindings = $result->getBindings();
        $this->assertContains("%{$searchTerm}%", $bindings);
    }

    public function test_it_applies_search_filter_to_faqs_model(): void
    {
        $query = Faq::query();
        $searchTerm = 'how to';

        $result = $this->callApplyFilter($query, $searchTerm);

        $sql = $result->toSql();
        $this->assertStringContainsString('question', $sql);
        $this->assertStringContainsString('answer', $sql);

        $bindings = $result->getBindings();
        $this->assertContains("%{$searchTerm}%", $bindings);
    }

    public function test_it_applies_search_filter_to_questions_model(): void
    {
        $query = Question::query();
        $searchTerm = 'solve equation';

        $result = $this->callApplyFilter($query, $searchTerm);

        $sql = $result->toSql();
        $this->assertStringContainsString('question', $sql);
        $this->assertStringContainsString('explanation', $sql);

        $bindings = $result->getBindings();
        $this->assertContains("%{$searchTerm}%", $bindings);
    }

    public function test_it_skips_filter_when_search_parameter_is_missing(): void
    {
        $query = Test::query();
        $originalSql = $query->toSql();

        $result = $this->callApplyFilter($query, null);

        $this->assertEquals($originalSql, $result->toSql());
    }

    public function test_it_skips_filter_when_search_term_is_empty(): void
    {
        $query = Test::query();
        $originalSql = $query->toSql();

        $result = $this->callApplyFilter($query, '');

        $this->assertEquals($originalSql, $result->toSql());
    }

    public function test_it_skips_filter_when_search_term_is_whitespace_only(): void
    {
        $query = Test::query();
        $originalSql = $query->toSql();

        $result = $this->callApplyFilter($query, '   ');

        $this->assertEquals($originalSql, $result->toSql());
    }

    public function test_it_trims_search_term_before_applying(): void
    {
        $query = Test::query();
        $searchTerm = '  mathematics  ';

        $result = $this->callApplyFilter($query, $searchTerm);

        $bindings = $result->getBindings();
        $this->assertContains('%mathematics%', $bindings);
        $this->assertNotContains('%  mathematics  %', $bindings);
    }

    public function test_it_returns_unchanged_query_for_unsupported_model(): void
    {
        // Create a mock model with unsupported table name
        $mockModel = Mockery::mock('Illuminate\Database\Eloquent\Model');
        $mockModel->shouldReceive('getTable')->andReturn('unsupported_table');

        $mockQuery = Mockery::mock(Builder::class);
        $mockQuery->shouldReceive('getModel')->andReturn($mockModel);
        $mockQuery->shouldReceive('toSql')->andReturn('SELECT * FROM unsupported_table');

        $result = $this->callApplyFilter($mockQuery, 'test');

        $this->assertInstanceOf(Builder::class, $result);
    }

    public function test_it_allows_configuring_search_fields_for_model(): void
    {
        $customFields = ['custom_field_1', 'custom_field_2'];

        $this->filter->setSearchFields('tests', $customFields);

        // Use reflection to access protected property
        $reflection = new \ReflectionClass($this->filter);
        $searchFieldsProperty = $reflection->getProperty('searchFields');
        $searchFieldsProperty->setAccessible(true);
        $searchFields = $searchFieldsProperty->getValue($this->filter);

        $this->assertEquals($customFields, $searchFields['tests']);
    }

    public function test_it_returns_self_when_setting_search_fields(): void
    {
        $result = $this->filter->setSearchFields('tests', ['title']);

        $this->assertSame($this->filter, $result);
    }

    public function test_it_creates_or_conditions_for_multiple_fields(): void
    {
        $query = Test::query();
        $searchTerm = 'test';

        $result = $this->callApplyFilter($query, $searchTerm);

        $sql = $result->toSql();

        // Should contain OR conditions between fields
        $this->assertStringContainsString('or', strtolower($sql));

        // Should have multiple LIKE conditions
        $likeCount = substr_count(strtolower($sql), 'like');
        $this->assertGreaterThan(1, $likeCount);
    }

    public function test_it_uses_wildcard_matching_for_search_terms(): void
    {
        $query = Test::query();
        $searchTerm = 'math';

        $result = $this->callApplyFilter($query, $searchTerm);

        $bindings = $result->getBindings();

        foreach ($bindings as $binding) {
            if (str_contains($binding, $searchTerm)) {
                $this->assertStringStartsWith('%', $binding);
                $this->assertStringEndsWith('%', $binding);
            }
        }
    }
}
