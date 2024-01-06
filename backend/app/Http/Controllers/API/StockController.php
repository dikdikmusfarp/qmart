<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiBaseController;
use App\Http\Controllers\Controller;
use App\Models\Item\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends ApiBaseController
{
    // MENAMPILKAN LIST PADA TABEL ITEMS DENGAN ATTRIBUTE (REQUEST)
    public function index(Request $request)
    {
        $attributes = $request->all();
        $data = Stock::filterQuery($attributes)
            ->paginate(
                isset($attributes['perPage']) ? $attributes['perPage'] : 100,
                ['*'],
                'page',
                isset($attributes['page']) ? $attributes['page'] : 1
            );
        // foreach ($data as $key => $value) {
        //     $transaksi = $tran
        // }
        try {
            return $this->sendResponse($data, 'Menampilkan list stock');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    // MEMBUAT DATA BARU PADA TABEL ITEMS
    public function store(Request $request)
    {
        try {
            $request->validate([
                'item_id' => 'required|numeric',
                'stock' => 'required|numeric',
                'transaction_time' => 'required|date',
            ]);
            if ($request->item_id) {
                DB::beginTransaction();
                $model = new Stock();
                $model->item_id = $request->item_id;
                $model->stock = $request->stock;
                $model->transaction_time = $request->transaction_time;
                $model->save();
                DB::commit();
                return $this->sendResponse($model, 'stock berhasil dibuat');
            } else {
                throw new \Exception("Pastikan mengisi nama barang");
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
    }

    // MENAMPILKAN DATA SPESIFIK BARANG DENGAN PARAMETER (ID)
    // public function show($id)
    // {
    //     try {
    //         $data = Item::select(
    //             'items.id',
    //             'items.name',
    //             'items.price',
    //             'types.name as type'
    //         )
    //         ->leftJoin('types', function ($join) {
    //             $join->on('types.id', '=', 'items.type_id');
    //         })
    //         ->where('items.id', $id)
    //         ->first();
    //         if ($data) {
    //             return $this->sendResponse($data, 'Menampilkan detail data barang');
    //         } else {
    //             throw new \Exception("Error, undefined type");
    //         }
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return $this->sendError($e->getMessage());
    //     }
    // }

    // MENGUBAH DATA SPESIFIK BARANG DENGAN PARAMETER (ID) DAN ATTRIBUTE (REQUEST)
    // public function update(Request $request, $id)
    // {
    //     try {
    //         $request->validate([
    //             'name' => 'required|string',
    //             'price' => 'required|numeric',
    //             'type_id' => 'required|numeric',
    //         ]);
    //         $data = Item::find($id);
    //         if ($data) {
    //             $data->name = ucwords($request->name);
    //             $data->price = $request->price;
    //             $data->type_id = $request->type_id;
    //             $data->save();
    //         }
    //         else {
    //             throw new \Exception("Error, undefined type");
    //         }
    //         return $this->sendResponse($data, 'Berhasil memperbaharui data barang');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return $this->sendError($e->getMessage());
    //     }
    // }

    // MENGHAPUS DATA SPESIFIK BARANG DENGAN PARAMETER (ID)
    // public function delete($id)
    // {
    //     try {
    //         $model = Item::find($id);
    //         if ($model) {
    //             $model->delete();
    //         } else {
    //             throw new \Exception("Error, undefined type");
    //         }
    //         return $this->sendResponse($model, 'Berhasil menghapus data barang');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return $this->sendError($e->getMessage());
    //     }
    // }
}
