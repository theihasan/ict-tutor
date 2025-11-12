<?php

namespace App\Pipelines\Filters;

use App\Pipelines\Contracts\FilterPipeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class BaseFilter implements FilterPipeInterface
{
    /**
     * The request parameter name this filter responds to
     */
    protected string $parameter;

    /**
     * Whether this filter requires a value to be present
     */
    protected bool $requiresValue = true;

    /**
     * Default implementation of shouldApply
     */
    public function shouldApply(Request $request): bool
    {
        if ($this->requiresValue) {
            return $request->filled($this->parameter);
        }

        return $request->has($this->parameter);
    }

    /**
     * Get the filter value from the request
     */
    protected function getValue(Request $request): mixed
    {
        return $request->get($this->parameter);
    }

    /**
     * Get multiple filter values from the request
     */
    protected function getValues(Request $request, array $parameters): array
    {
        return $request->only($parameters);
    }

    /**
     * Apply the filter logic (to be implemented by subclasses)
     */
    abstract protected function applyFilter(Builder $query, mixed $value): Builder;

    /**
     * Handle the filter application
     */
    public function handle(Builder $query, \Closure $next, Request $request): Builder
    {
        if ($this->shouldApply($request)) {
            $value = $this->getValue($request);
            $query = $this->applyFilter($query, $value);
        }

        return $next($query);
    }
}
