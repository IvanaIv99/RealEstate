<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class QueryFilters
{
    protected $request;
    protected $builder;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     *  Apply() method loops through the associative array returned by filters() and if the inheriting class has a method with the name of the request key, it executes that method, passing it a parameter with the request value if exists.
     */
    public function apply(Builder $builder)
    {
        $this->builder = $builder;
        foreach ($this->filters() as $name => $value) {
            if ( ! method_exists($this, $name)) {
                continue;
            }
            if (strlen($value)) {
                $this->$name($value);
            } else {
                $this->$name();
            }
        }

        return $this->builder;
    }

    /**
     *  Returns an associative array contain input values in the url and body of the request
     */
    public function filters()
    {
        return $this->request->all();
    }
}
