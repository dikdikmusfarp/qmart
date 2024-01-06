<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    use HasFactory;

    protected $table = 'sale_details';

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
                else if ($attributes['order_column'] == 'jumlah') {
                    $orderName = 'sale_details.amount';
                }
                else if ($attributes['order_column'] == 'harga') {
                    $orderName = 'sale_details.price_at';
                }
                else if ($attributes['order_column'] == 'total') {
                    $orderName = 'sale_details.total';
                }
                else if ($attributes['order_column'] == 'waktu') {
                    $orderName = 'sales.transaction_time';
                }
                else if ($attributes['order_column'] == 'jenis') {
                    $orderName = 'types.name';
                }
                else {
                    $orderName = 'sale_details.id';
                }
            } else {
                $orderName = 'sale_details.id';
            }
            return self::select(
                'sale_details.id',
                'items.name as nama',
                'sale_details.amount as jumlah',
                'sale_details.price_at as harga',
                'sale_details.total',
                'sales.transaction_time as waktu',
                'types.name as jenis',
            )
                ->leftJoin('sales', function ($join) {
                    $join->on('sales.id', '=', 'sale_details.sale_id');
                })
                ->leftJoin('items', function ($join) {
                    $join->on('items.id', '=', 'sale_details.item_id');
                })
                ->leftJoin('types', function ($join) {
                    $join->on('types.id', '=', 'items.type_id');
                })
                ->where(function ($query) use ($attributes) {
                    if (isset($attributes['search'])) {
                        $query->where('items.name', 'ilike', '%' . $attributes['search'] . '%')
                            ->orWhere('sale_details.amount', 'ilike', '%' . $attributes['search'] . '%')
                            ->orWhere('types.name', 'ilike', '%' . $attributes['search'] . '%')
                            ->orWhere('sale_details.price_at', 'ilike', '%' . $attributes['search'] . '%')
                            ->orWhere('sale_details.total', 'ilike', '%' . $attributes['search'] . '%')
                            ->orWhere('sales.transaction_time', 'ilike', '%' . $attributes['search'] . '%');
                    }
                })
                ->where(function ($filter) use ($attributes) {
                    if (isset($attributes['start']) && isset($attributes['end'])) {
                        $filter->whereBetween('sales.transaction_time', [$attributes['start'],$attributes['end']]);
                    }
                })
                ->orderByRaw($orderName . " " . $orderDorection . " NULLS LAST");
    }
}
