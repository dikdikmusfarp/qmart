<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiBaseController;
use App\Http\Controllers\Controller;
use App\Models\Item\Item;
use App\Models\Transaction\SaleDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends ApiBaseController
{
    // MENAMPILKAN LIST PADA TABEL ITEMS DENGAN ATTRIBUTE (REQUEST)
    public function index(Request $request)
    {
        $attributes = $request->all();
        $data = Item::filterQuery($attributes)
            ->paginate(
                isset($attributes['perPage']) ? $attributes['perPage'] : 100,
                ['*'],
                'page',
                isset($attributes['page']) ? $attributes['page'] : 1
            );
        foreach ($data as $key => $value) {
            $terjual = SaleDetail::select(
                'sale_details.item_id',
                DB::raw('SUM(sale_details.amount) as total'),
            )->where('sale_details.item_id', $value->id)
            ->groupBy('sale_details.item_id')
            ->first();
            if ($terjual) {
                $value->total_stock = $value->total_stock - $terjual->total;
            }
        }
        try {
            return $this->sendResponse($data, 'Menampilkan list barang');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    // MEMBUAT DATA BARU PADA TABEL ITEMS
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'price' => 'required|numeric',
                'type_id' => 'required|numeric',
            ]);
            if ($request->name) {
                DB::beginTransaction();
                $model = new Item();
                $model->name = ucwords($request->name); // Membuat huruf awal pada kata menjadi kapital
                $model->price = $request->price;
                $model->type_id = $request->type_id;
                $model->save();
                DB::commit();
                return $this->sendResponse($model, 'Barang berhasil dibuat');
            } else {
                throw new \Exception("Pastikan mengisi nama barang");
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
    }

    // MENAMPILKAN DATA SPESIFIK BARANG DENGAN PARAMETER (ID)
    public function show($id)
    {
        try {
            $data = Item::select(
                'items.id',
                'items.name',
                'items.price',
                'types.id as type_id',
                'types.name as type'
            )
            ->leftJoin('types', function ($join) {
                $join->on('types.id', '=', 'items.type_id');
            })
            ->where('items.id', $id)
            ->first();
            if ($data) {
                return $this->sendResponse($data, 'Menampilkan detail data barang');
            } else {
                throw new \Exception("Error, undefined type");
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
    }

    // MENGUBAH DATA SPESIFIK BARANG DENGAN PARAMETER (ID) DAN ATTRIBUTE (REQUEST)
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'price' => 'required|numeric',
                'type_id' => 'required|numeric',
            ]);
            $data = Item::find($id);
            if ($data) {
                $data->name = ucwords($request->name);
                $data->price = $request->price;
                $data->type_id = $request->type_id;
                $data->save();
            }
            else {
                throw new \Exception("Error, undefined type");
            }
            return $this->sendResponse($data, 'Berhasil memperbaharui data barang');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
    }

    // MENGHAPUS DATA SPESIFIK BARANG DENGAN PARAMETER (ID)
    public function delete($id)
    {
        try {
            $model = Item::find($id);
            if ($model) {
                $model->delete();
            } else {
                throw new \Exception("Error, undefined type");
            }
            return $this->sendResponse($model, 'Berhasil menghapus data barang');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
    }

    public function list()
    {
        try {
            $data = Item::select(
                'id',
                'name',
            )->get();
            if ($data) {
                return $this->sendResponse($data, 'Menampilkan list data barang');
            } else {
                throw new \Exception("Error, undefined type");
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
    }
}
