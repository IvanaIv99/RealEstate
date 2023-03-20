<?php

namespace App\Models;

use App\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Unit extends Model
{
    /**
     *  Filterable is a custom trait for applying filters(search).
     */
    use HasFactory, Filterable;

    protected $table = 'units';

    public $timestamps = true;

    protected $fillable = [
        'id_type',
        'address',
        'size',
        'bedrooms',
        'price',
        'longitude',
        'latitude'
    ];

    protected $with = [
        'unit_type:id,type'
    ];

    public function unit_type(){
        return $this->hasOne(UnitType::class,'id');
    }







}
