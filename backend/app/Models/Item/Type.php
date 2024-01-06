<?php

namespace App\Models\Item;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Type extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'types';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'updated_at',
        'deleted_at',
    ];

    public static function filterQuery($attributes)
    {
        $orderDorection = isset($attributes['order_direction']) ? filter_var($attributes['order_direction'], FILTER_VALIDATE_BOOLEAN) ? 'DESC' : 'ASC' : 'ASC';
            if (isset($attributes['order_column'])) {
                $orderName = 'types.' . $attributes['order_column'];
            } else {
                $orderName = 'types.id';
            }
            return self::select(
                'id',
                'name',
            )
                ->where(function ($query) use ($attributes) {
                    if (isset($attributes['search'])) {
                        $query->where('types.name', 'ilike', '%' . $attributes['search'] . '%');
                    }
                })
                ->orderByRaw($orderName . " " . $orderDorection . " NULLS LAST");
    }
}
