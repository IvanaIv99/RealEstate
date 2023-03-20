<?php
namespace App\Filters;
use Illuminate\Http\Request;

class UnitFilters extends QueryFilters
{
    /**
     * Extended QueryFilter class with filters for Units.
     */

    protected $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }

    public function search($term) {
        return $this->builder->whereFullText('address', $term);
    }

    public function min_price($term) {
        return $this->builder->where('price', '>=',$term);
    }

    public function max_price($term) {
        return $this->builder->where('price', '<=',$term);
    }

    public function min_bedrooms($term) {
        return $this->builder->where('bedrooms','<=',$term);
    }

    public function max_bedrooms($term) {
        return $this->builder->where('bedrooms','>=',$term);
    }

    public function min_size($term) {
        return $this->builder->where('size','<=',$term);
    }

    public function max_size($term) {
        return $this->builder->where('size','>=',$term);
    }

    public function distance($term) {

        list($lat,$lng,$radius) = explode(",",$term);

        $haversine = "(
        6371 * acos(
            cos(radians(?))
            * cos(radians(`latitude`))
            * cos(radians(`longitude`) - radians(?))
            + sin(radians(?)) * sin(radians(`latitude`))
        ))";

        return $this->builder
            ->selectRaw("id,address,size,bedrooms,price,$haversine AS distance",[$lat,$lng,$lat])
            ->having("distance", "<=", $radius)
            ->orderBy("distance");
    }
}
