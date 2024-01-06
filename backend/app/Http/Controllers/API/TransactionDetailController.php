<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiBaseController;
use App\Http\Controllers\Controller;
use App\Models\Item\Item;
use App\Models\Transaction\Sale;
use App\Models\Transaction\SaleDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionDetailController extends ApiBaseController
{
    // MENAMPILKAN LIST PADA TABEL TYPES DENGAN ATTRIBUTE (REQUEST)
    public function index(Request $request)
    {
        $attributes = $request->all();
        $data = SaleDetail::filterQuery($attributes)
            ->paginate(
                isset($attributes['perPage']) ? $attributes['perPage'] : 100,
                ['*'],
                'page',
                isset($attributes['page']) ? $attributes['page'] : 1
            );
        try {
            return $this->sendResponse($data, 'Menampilkan list detail traksaksi');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    // MEMBUAT DATA BARU PADA TABEL TYPES
    public function store(Request $request)
    {
        try {
            $request->validate([
                'sale_id' => 'required|numeric',
                'item_id' => 'required|numeric',
                'amount' => 'required|numeric',

            ]);
            if ($request->sale_id) {
                $item = Item::find($request->item_id);
                $sale = Sale::find($request->sale_id);
                if ($item && $sale) {
                    DB::beginTransaction();
                    $model = new SaleDetail();
                    $model->sale_id = $request->sale_id;
                    $model->item_id = $request->item_id;
                    $model->amount = $request->amount;
                    $model->price_at = $item->price;
                    $model->total = $item->price * $request->amount;
                    $model->save();
                    DB::commit();
                    return $this->sendResponse($model, 'Detail Transaksi berhasil dibuat');
                }
                else {
                    throw new \Exception("Pastikan mengisi form");
                }
            } else {
                throw new \Exception("Pastikan mengisi form");
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
    }

    // MENAMPILKAN DATA SPESIFIK JENIS BARANG DENGAN PARAMETER (ID)
    public function show($id)
    {
        try {
            $data = SaleDetail::where('id', $id)->first();
            if ($data) {
                return $this->sendResponse($data, 'Menampilkan detail data transaksi');
            } else {
                throw new \Exception("Error, undefined type");
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
    }

    // MENGUBAH DATA SPESIFIK JENIS BARANG DENGAN PARAMETER (ID) DAN ATTRIBUTE (REQUEST)
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'sale_id' => 'required|numeric',
                'item_id' => 'required|numeric',
                'amount' => 'required|numeric',
            ]);
            $data = Sale::find($id);
            $item = Item::find($request->item_id);
            $sale = Sale::find($request->sale_id);
            if ($data && $item && $sale) {
                $data->sale_id = $request->sale_id;
                $data->item_id = $request->item_id;
                $data->amount = $request->amount;
                $data->price_at = $item->price;
                $data->total = $item->price * $request->amount;
                $data->save();
            }
            else {
                throw new \Exception("Error, undefined type");
            }
            return $this->sendResponse($data, 'Berhasil memperbaharui data transaksi');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
    }

    // MENGHAPUS DATA SPESIFIK JENIS BARANG DENGAN PARAMETER (ID)
    public function delete($id)
    {
        try {
            $model = SaleDetail::find($id);
            if ($model) {
                $model->delete();
            } else {
                throw new \Exception("Error, undefined type");
            }
            return $this->sendResponse($model, 'Berhasil menghapus data detail transaksi');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
    }
}
