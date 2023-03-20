<?php
namespace App\Filters;

trait Filterable
{
    /**
     * Scope a query to apply filtering.
     */
    public function scopeFilter($query, QueryFilters $filters)
    {
        return $filters->apply($query);
    }
}
