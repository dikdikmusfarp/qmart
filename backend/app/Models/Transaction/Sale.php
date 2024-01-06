<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $table = 'sales';

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
                if ($attributes['order_column'] == 'waktu') {
                    $orderName = 'sales.transaction_time';
                }
                else {
                    $orderName = 'sales.id';
                }
            } else {
                $orderName = 'sales.id';
            }
            return self::select(
                'sales.id',
                'sales.transaction_time as waktu',
            )
                ->where(function ($query) use ($attributes) {
                    if (isset($attributes['search'])) {
                        $query->where('sales.transaction_time', 'ilike', '%' . $attributes['search'] . '%');
                    }
                })
                ->orderByRaw($orderName . " " . $orderDorection . " NULLS LAST");
    }
}
