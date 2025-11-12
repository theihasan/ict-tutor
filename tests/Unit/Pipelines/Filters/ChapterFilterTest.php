<?php

namespace Tests\Unit\Pipelines\Filters;

use App\Models\Test;
use App\Pipelines\Filters\ChapterFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class ChapterFilterTest extends TestCase
{
    use RefreshDatabase;

    private ChapterFilter $filter;

    protected function setUp(): void
    {
        parent::setUp();
        $this->filter = new ChapterFilter;
    }

    #[Test]
    public function it_applies_single_chapter_id_filter(): void
    {
        $query = Test::query();
        $chapterId = 5;

        $result = $this->filter->apply($query, ['chapter_id' => $chapterId]);

        $this->assertInstanceOf(Builder::class, $result);

        $sql = $result->toSql();
        $this->assertStringContainsString('chapter_id', $sql);
        $this->assertStringNotContainsString('in', strtolower($sql));

        $bindings = $result->getBindings();
        $this->assertContains($chapterId, $bindings);
    }

    #[Test]
    public function it_applies_multiple_chapter_ids_filter(): void
    {
        $query = Test::query();
        $chapterIds = [1, 2, 3];

        $result = $this->filter->apply($query, ['chapter_id' => $chapterIds]);

        $sql = $result->toSql();
        $this->assertStringContainsString('chapter_id', $sql);
        $this->assertStringContainsString('in', strtolower($sql));

        $bindings = $result->getBindings();
        foreach ($chapterIds as $id) {
            $this->assertContains($id, $bindings);
        }
    }

    #[Test]
    public function it_filters_out_invalid_chapter_ids(): void
    {
        $query = Test::query();
        $mixedIds = [1, 'invalid', 0, -1, 2, null, '', 3];

        $result = $this->filter->apply($query, ['chapter_id' => $mixedIds]);

        $sql = $result->toSql();
        $bindings = $result->getBindings();

        // Should only include valid IDs: 1, 2, 3
        $this->assertContains(1, $bindings);
        $this->assertContains(2, $bindings);
        $this->assertContains(3, $bindings);
        $this->assertNotContains('invalid', $bindings);
        $this->assertNotContains(0, $bindings);
        $this->assertNotContains(-1, $bindings);
    }

    #[Test]
    public function it_returns_unchanged_query_when_no_valid_ids(): void
    {
        $query = Test::query();
        $originalSql = $query->toSql();

        $result = $this->filter->apply($query, ['chapter_id' => ['invalid', 0, -1, null]]);

        $this->assertEquals($originalSql, $result->toSql());
    }

    #[Test]
    public function it_skips_filter_when_chapter_id_parameter_is_missing(): void
    {
        $query = Test::query();
        $originalSql = $query->toSql();

        $result = $this->filter->apply($query, []);

        $this->assertEquals($originalSql, $result->toSql());
    }

    #[Test]
    public function it_handles_string_numeric_ids(): void
    {
        $query = Test::query();
        $chapterIds = ['1', '2', '3'];

        $result = $this->filter->apply($query, ['chapter_id' => $chapterIds]);

        $bindings = $result->getBindings();
        $this->assertContains(1, $bindings);
        $this->assertContains(2, $bindings);
        $this->assertContains(3, $bindings);
    }

    #[Test]
    public function it_supports_alternative_parameter_names(): void
    {
        // Test 'chapter' parameter
        $request1 = Request::create('/', 'GET', ['chapter' => 5]);
        $shouldApply1 = $this->filter->shouldApply($request1);
        $this->assertTrue($shouldApply1);

        // Test 'chapters' parameter
        $request2 = Request::create('/', 'GET', ['chapters' => [1, 2]]);
        $shouldApply2 = $this->filter->shouldApply($request2);
        $this->assertTrue($shouldApply2);

        // Test 'chapter_id' parameter
        $request3 = Request::create('/', 'GET', ['chapter_id' => 3]);
        $shouldApply3 = $this->filter->shouldApply($request3);
        $this->assertTrue($shouldApply3);
    }

    #[Test]
    public function it_prefers_chapter_id_over_alternative_parameters(): void
    {
        $request = Request::create('/', 'GET', [
            'chapter_id' => 1,
            'chapter' => 2,
            'chapters' => [3, 4],
        ]);

        // Use reflection to access protected method
        $reflection = new \ReflectionClass($this->filter);
        $getValueMethod = $reflection->getMethod('getValue');
        $getValueMethod->setAccessible(true);

        $value = $getValueMethod->invoke($this->filter, $request);

        $this->assertEquals(1, $value);
    }

    #[Test]
    public function it_falls_back_to_chapter_parameter(): void
    {
        $request = Request::create('/', 'GET', [
            'chapter' => 2,
            'chapters' => [3, 4],
        ]);

        // Use reflection to access protected method
        $reflection = new \ReflectionClass($this->filter);
        $getValueMethod = $reflection->getMethod('getValue');
        $getValueMethod->setAccessible(true);

        $value = $getValueMethod->invoke($this->filter, $request);

        $this->assertEquals(2, $value);
    }

    #[Test]
    public function it_falls_back_to_chapters_parameter_last(): void
    {
        $request = Request::create('/', 'GET', ['chapters' => [3, 4]]);

        // Use reflection to access protected method
        $reflection = new \ReflectionClass($this->filter);
        $getValueMethod = $reflection->getMethod('getValue');
        $getValueMethod->setAccessible(true);

        $value = $getValueMethod->invoke($this->filter, $request);

        $this->assertEquals([3, 4], $value);
    }

    #[Test]
    public function it_should_not_apply_when_no_chapter_parameters_present(): void
    {
        $request = Request::create('/', 'GET', ['other_param' => 'value']);

        $shouldApply = $this->filter->shouldApply($request);

        $this->assertFalse($shouldApply);
    }

    #[Test]
    public function it_converts_single_value_to_array_internally(): void
    {
        $query = Test::query();
        $chapterId = 5;

        $result = $this->filter->apply($query, ['chapter_id' => $chapterId]);

        // Single ID should use WHERE instead of WHERE IN
        $sql = $result->toSql();
        $this->assertStringNotContainsString('in', strtolower($sql));
        $this->assertStringContainsString('=', $sql);
    }

    #[Test]
    public function it_handles_empty_array_gracefully(): void
    {
        $query = Test::query();
        $originalSql = $query->toSql();

        $result = $this->filter->apply($query, ['chapter_id' => []]);

        $this->assertEquals($originalSql, $result->toSql());
    }

    #[Test]
    public function it_maintains_query_builder_instance_type(): void
    {
        $query = Test::query();

        $result = $this->filter->apply($query, ['chapter_id' => 1]);

        $this->assertInstanceOf(Builder::class, $result);
        $this->assertInstanceOf(Test::class, $result->getModel());
    }

    #[Test]
    public function it_handles_mixed_numeric_and_string_values(): void
    {
        $query = Test::query();
        $mixedValues = [1, '2', 3, '4'];

        $result = $this->filter->apply($query, ['chapter_id' => $mixedValues]);

        $bindings = $result->getBindings();
        $this->assertContains(1, $bindings);
        $this->assertContains(2, $bindings);
        $this->assertContains(3, $bindings);
        $this->assertContains(4, $bindings);
    }
}
