<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CMDB extends Model
{
    /** @use HasFactory<\Database\Factories\CMDBFactory> */
    use HasFactory;

    protected $table = "cmdb";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['identificator', 'name', 'category_id', 'optional_values'];

    /**
     * Interact with the user's first name.
     */
    protected function optionalValues(): Attribute
    {
        return Attribute::make(
            set: fn (array $value) => json_encode($value, JSON_FORCE_OBJECT),
        );
    }
}
