<?php

namespace App\Http\Controllers;

use App\Filters\UnitFilters;
use App\Models\Unit;
use App\Http\Requests\UnitsRequest;


class UnitController extends Controller
{

    /**
     * Store a newly created resource in storage using custom validation rules.
     */
    public function store(UnitsRequest $request)
    {
        $unit = Unit::create($request->all());
        return response(['message' => 'Created successfully','data' => $unit], 201);

    }

    /**
     * Search and show resources.
     */
    public function index(UnitFilters $filters)
    {

        $units = Unit::select('id','address','size','bedrooms','price')
            ->filter($filters)->paginate();

        return response(['data' => $units], 200);

    }


}
