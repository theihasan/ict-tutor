<?php

namespace App\Pipelines;

use App\Pipelines\Contracts\FilterPipeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;

class FilterPipeline
{
    protected Pipeline $pipeline;

    protected array $pipes = [];

    public function __construct(Pipeline $pipeline)
    {
        $this->pipeline = $pipeline;
    }

    /**
     * Add a filter to the pipeline
     */
    public function addFilter(string|FilterPipeInterface $filter): self
    {
        $this->pipes[] = $filter;

        return $this;
    }

    /**
     * Add multiple filters to the pipeline
     */
    public function addFilters(array $filters): self
    {
        foreach ($filters as $filter) {
            $this->addFilter($filter);
        }

        return $this;
    }

    /**
     * Apply all filters to the query
     */
    public function apply(Builder $query, array|Request $request): Builder
    {
        $requestData = $request instanceof Request ? $request : new Request($request);

        return $this->pipeline
            ->send($query)
            ->through($this->buildPipes($requestData))
            ->thenReturn();
    }

    /**
     * Build the pipeline with request context
     */
    protected function buildPipes(Request $request): array
    {
        return collect($this->pipes)
            ->map(function ($pipe) use ($request) {
                if (is_string($pipe)) {
                    $pipe = app($pipe);
                }

                // Only include filters that should be applied
                if ($pipe instanceof FilterPipeInterface && ! $pipe->shouldApply($request)) {
                    return null;
                }

                // Return closure that passes request to the pipe
                return function (Builder $query, \Closure $next) use ($pipe, $request) {
                    if ($pipe instanceof FilterPipeInterface) {
                        return $pipe->handle($query, $next, $request);
                    }

                    // For regular pipeline classes, just pass the query
                    return $pipe->handle($query, $next);
                };
            })
            ->filter()
            ->values()
            ->all();
    }

    /**
     * Get all registered filters
     */
    public function getFilters(): array
    {
        return $this->pipes;
    }

    /**
     * Create a new instance
     */
    public static function make(): self
    {
        return new self(app(Pipeline::class));
    }
}
