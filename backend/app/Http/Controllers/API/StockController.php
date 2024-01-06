<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiBaseController;
use App\Http\Controllers\Controller;
use App\Models\Item\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends ApiBaseController
{
    // MEMBUAT DATA BARU PADA TABEL ITEMS
    public function store(Request $request)
    {
        try {
            $request->validate([
                'item_id' => 'required|numeric',
                'stock' => 'required|numeric',
            ]);
            if ($request->item_id) {
                DB::beginTransaction();
                $model = new Stock();
                $model->item_id = $request->item_id;
                $model->stock = $request->stock;
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
}
