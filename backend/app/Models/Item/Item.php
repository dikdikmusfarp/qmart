<?php

namespace App\Models\Item;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'items';

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
                if ($attributes['order_column'] == 'nama') {
                    $orderName = 'items.name';
                }
                else if ($attributes['order_column'] == 'jenis') {
                    $orderName = 'types.name';
                }
                else if ($attributes['order_column'] == 'harga') {
                    $orderName = 'items.price';
                }
                else {
                    $orderName = 'items.id';
                }
            } else {
                $orderName = 'items.id';
            }
            return self::select(
                'items.id',
                'items.name as nama',
                'items.price as harga',
                'types.name as jenis',
                DB::raw('SUM(stocks.stock) as total_stock'),
            )
                ->leftJoin('types', function ($join) {
                    $join->on('types.id', '=', 'items.type_id');
                })
                ->leftJoin('stocks', function ($join) {
                    $join->on('stocks.item_id', '=', 'items.id');
                })
                ->where(function ($query) use ($attributes) {
                    if (isset($attributes['search'])) {
                        $query->where('items.name', 'ilike', '%' . $attributes['search'] . '%')
                            ->orWhere('items.price', 'ilike', '%' . $attributes['search'] . '%')
                            ->orWhere('types.name', 'ilike', '%' . $attributes['search'] . '%');
                    }
                })
                ->groupBy('items.id', 'items.name', 'items.price', 'types.name')
                ->orderByRaw($orderName . " " . $orderDorection . " NULLS LAST");
    }
}
