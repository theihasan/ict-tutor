<?php

namespace Tests\Unit\Pipelines;

use App\Pipelines\FilterPipeline;
use App\Pipelines\Filters\SearchFilter;
use App\Pipelines\Filters\TypeFilter;
use Illuminate\Database\Eloquent\Builder;
use Mockery;
use Tests\TestCase;

class FilterPipelineTest extends TestCase
{
    #[Test]
    public function it_can_add_filters_to_the_pipeline(): void
    {
        $pipeline = new FilterPipeline(app(\Illuminate\Pipeline\Pipeline::class));
        $searchFilter = new SearchFilter;
        $typeFilter = new TypeFilter;

        $result = $pipeline->addFilter($searchFilter)->addFilter($typeFilter);

        $this->assertSame($pipeline, $result);
        $this->assertCount(2, $pipeline->getFilters());
    }

    #[Test]
    public function it_applies_filters_to_query_builder(): void
    {
        $pipeline = new FilterPipeline(app(\Illuminate\Pipeline\Pipeline::class));
        $mockQuery = Mockery::mock(Builder::class);

        // Mock a filter that should be applied
        $mockFilter = Mockery::mock('\App\Pipelines\Contracts\FilterPipeInterface');
        $mockFilter->shouldReceive('shouldApply')
            ->once()
            ->andReturn(true);
        $mockFilter->shouldReceive('handle')
            ->with($mockQuery, Mockery::type('Closure'), Mockery::type('\Illuminate\Http\Request'))
            ->once()
            ->andReturnUsing(function ($query, $next, $request) {
                return $next($query);
            });

        $pipeline->addFilter($mockFilter);
        $result = $pipeline->apply($mockQuery, ['search' => 'test']);

        $this->assertInstanceOf(Builder::class, $result);
    }

    #[Test]
    public function it_skips_filters_that_should_not_apply(): void
    {
        $pipeline = new FilterPipeline(app(\Illuminate\Pipeline\Pipeline::class));
        $mockQuery = Mockery::mock(Builder::class);

        // Mock a filter that should not be applied
        $mockFilter = Mockery::mock('\App\Pipelines\Contracts\FilterPipeInterface');
        $mockFilter->shouldReceive('shouldApply')
            ->once()
            ->andReturn(false);
        $mockFilter->shouldNotReceive('handle');

        $pipeline->addFilter($mockFilter);
        $result = $pipeline->apply($mockQuery, []);

        $this->assertInstanceOf(Builder::class, $result);
    }

    #[Test]
    public function it_applies_multiple_filters_in_sequence(): void
    {
        $pipeline = new FilterPipeline(app(\Illuminate\Pipeline\Pipeline::class));
        $mockQuery = Mockery::mock(Builder::class);

        // Mock first filter
        $firstFilter = Mockery::mock('\App\Pipelines\Contracts\FilterPipeInterface');
        $firstFilter->shouldReceive('shouldApply')->andReturn(true);
        $firstFilter->shouldReceive('handle')
            ->andReturnUsing(function ($query, $next, $request) {
                return $next($query);
            });

        // Mock second filter
        $secondFilter = Mockery::mock('\App\Pipelines\Contracts\FilterPipeInterface');
        $secondFilter->shouldReceive('shouldApply')->andReturn(true);
        $secondFilter->shouldReceive('handle')
            ->andReturnUsing(function ($query, $next, $request) {
                return $next($query);
            });

        $pipeline->addFilter($firstFilter)->addFilter($secondFilter);
        $result = $pipeline->apply($mockQuery, ['test' => 'data']);

        $this->assertInstanceOf(Builder::class, $result);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
