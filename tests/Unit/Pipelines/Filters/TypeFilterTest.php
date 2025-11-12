<?php

namespace Tests\Unit\Pipelines\Filters;

use App\Enums\TestType;
use App\Models\Faq;
use App\Models\Test;
use App\Pipelines\Filters\TypeFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Mockery;
use Tests\TestCase;

class TypeFilterTest extends TestCase
{
    use RefreshDatabase;

    private TypeFilter $filter;

    protected function setUp(): void
    {
        parent::setUp();
        $this->filter = new TypeFilter;
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    #[Test]
    public function it_applies_test_type_filter_with_string_value(): void
    {
        $query = Test::query();
        $testType = 'model_test';

        $result = $this->filter->apply($query, ['type' => $testType]);

        $this->assertInstanceOf(Builder::class, $result);

        $sql = $result->toSql();
        $this->assertStringContainsString('type', $sql);

        $bindings = $result->getBindings();
        $this->assertContains(TestType::ModelTest, $bindings);
    }

    #[Test]
    public function it_applies_test_type_filter_with_enum_value(): void
    {
        $query = Test::query();
        $testType = TestType::PracticeTest;

        $result = $this->filter->apply($query, ['type' => $testType]);

        $sql = $result->toSql();
        $this->assertStringContainsString('type', $sql);

        $bindings = $result->getBindings();
        $this->assertContains(TestType::PracticeTest, $bindings);
    }

    #[Test]
    public function it_ignores_invalid_test_type_values(): void
    {
        $query = Test::query();
        $originalSql = $query->toSql();

        $result = $this->filter->apply($query, ['type' => 'invalid_test_type']);

        $this->assertEquals($originalSql, $result->toSql());
    }

    #[Test]
    public function it_applies_faq_category_filter(): void
    {
        $query = Faq::query();
        $category = 'general';

        $result = $this->filter->apply($query, ['type' => $category]);

        $this->assertInstanceOf(Builder::class, $result);
        // Note: The actual SQL will depend on the byCategory scope implementation
    }

    #[Test]
    public function it_ignores_invalid_faq_category_values(): void
    {
        $query = Faq::query();
        $originalSql = $query->toSql();

        $result = $this->filter->apply($query, ['type' => 'invalid_category']);

        $this->assertEquals($originalSql, $result->toSql());
    }

    #[Test]
    public function it_handles_generic_type_column_for_other_models(): void
    {
        // Create a mock model with a different table name
        $mockModel = Mockery::mock('Illuminate\Database\Eloquent\Model');
        $mockModel->shouldReceive('getTable')->andReturn('other_table');

        $mockQuery = Mockery::mock(Builder::class);
        $mockQuery->shouldReceive('getModel')->andReturn($mockModel);
        $mockQuery->shouldReceive('where')->with('type', 'some_type')->andReturnSelf();

        $result = $this->filter->apply($mockQuery, ['type' => 'some_type']);

        $this->assertInstanceOf(Builder::class, $result);
    }

    #[Test]
    public function it_skips_filter_when_type_parameter_is_missing(): void
    {
        $query = Test::query();
        $originalSql = $query->toSql();

        $result = $this->filter->apply($query, []);

        $this->assertEquals($originalSql, $result->toSql());
    }

    #[Test]
    public function it_supports_category_parameter_as_alternative(): void
    {
        $request = Request::create('/', 'GET', ['category' => 'general']);

        $shouldApply = $this->filter->shouldApply($request);

        $this->assertTrue($shouldApply);
    }

    #[Test]
    public function it_prefers_type_parameter_over_category(): void
    {
        $request = Request::create('/', 'GET', [
            'type' => 'model_test',
            'category' => 'general',
        ]);

        // Use reflection to access protected method
        $reflection = new \ReflectionClass($this->filter);
        $getValueMethod = $reflection->getMethod('getValue');
        $getValueMethod->setAccessible(true);

        $value = $getValueMethod->invoke($this->filter, $request);

        $this->assertEquals('model_test', $value);
    }

    #[Test]
    public function it_falls_back_to_category_parameter_when_type_is_missing(): void
    {
        $request = Request::create('/', 'GET', ['category' => 'general']);

        // Use reflection to access protected method
        $reflection = new \ReflectionClass($this->filter);
        $getValueMethod = $reflection->getMethod('getValue');
        $getValueMethod->setAccessible(true);

        $value = $getValueMethod->invoke($this->filter, $request);

        $this->assertEquals('general', $value);
    }

    #[Test]
    public function it_should_not_apply_when_neither_type_nor_category_present(): void
    {
        $request = Request::create('/', 'GET', ['other_param' => 'value']);

        $shouldApply = $this->filter->shouldApply($request);

        $this->assertFalse($shouldApply);
    }

    #[Test]
    public function it_handles_all_valid_test_types(): void
    {
        $query = Test::query();

        foreach (TestType::cases() as $testType) {
            $result = $this->filter->apply($query, ['type' => $testType->value]);

            $this->assertInstanceOf(Builder::class, $result);

            $bindings = $result->getBindings();
            $this->assertContains($testType, $bindings);
        }
    }

    #[Test]
    public function it_handles_null_and_empty_values(): void
    {
        $query = Test::query();
        $originalSql = $query->toSql();

        // Test null value
        $result1 = $this->filter->apply($query, ['type' => null]);
        $this->assertEquals($originalSql, $result1->toSql());

        // Test empty string
        $result2 = $this->filter->apply($query, ['type' => '']);
        $this->assertEquals($originalSql, $result2->toSql());
    }

    #[Test]
    public function it_maintains_query_builder_instance_type(): void
    {
        $query = Test::query();

        $result = $this->filter->apply($query, ['type' => 'model_test']);

        $this->assertInstanceOf(Builder::class, $result);
        $this->assertInstanceOf(Test::class, $result->getModel());
    }
}
