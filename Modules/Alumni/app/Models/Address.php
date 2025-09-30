<?php

namespace Modules\Alumni\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'address_id';

    protected $fillable = [
        'street',
        'city',
        'province',
        'postal_code',
        'country',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function alumni()
    {
        return $this->hasMany(Alumni::class, 'address_id', 'address_id');
    }

    public function getFullAddressAttribute()
    {
        return "{$this->street}, {$this->city}, {$this->province} {$this->postal_code}, {$this->country}";
    }
}
