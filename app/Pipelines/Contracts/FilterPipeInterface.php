<?php

namespace App\Pipelines\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

interface FilterPipeInterface
{
    /**
     * Apply the filter to the query builder
     */
    public function handle(Builder $query, \Closure $next, Request $request): Builder;

    /**
     * Determine if this filter should be applied
     */
    public function shouldApply(Request $request): bool;
}
