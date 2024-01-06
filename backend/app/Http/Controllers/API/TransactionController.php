<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiBaseController;
use App\Http\Controllers\Controller;
use App\Models\Transaction\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends ApiBaseController
{
    public function index(Request $request)
    {
        $attributes = $request->all();
        $data = Sale::filterQuery($attributes)
            ->paginate(
                isset($attributes['perPage']) ? $attributes['perPage'] : 100,
                ['*'],
                'page',
                isset($attributes['page']) ? $attributes['page'] : 1
            );
        try {
            return $this->sendResponse($data, 'Menampilkan list traksaksi');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'transaction_time' => 'required|date',
            ]);
            if ($request->transaction_time) {
                DB::beginTransaction();
                $model = new Sale();
                $model->transaction_time = $request->transaction_time;
                $model->save();
                DB::commit();
                return $this->sendResponse($model, 'Transaksi berhasil dibuat');
            } else {
                throw new \Exception("Pastikan mengisi waktu transaksi");
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $data = Sale::select(
                'id',
                'transaction_time',
            )->where('id', $id)->first();
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

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string',
            ]);
            $data = Sale::find($id);
            if ($data) {
                $data->transaction_time = $request->transaction_time;
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

    public function delete($id)
    {
        try {
            $model = Sale::find($id);
            if ($model) {
                $model->delete();
            } else {
                throw new \Exception("Error, undefined type");
            }
            return $this->sendResponse($model, 'Berhasil menghapus data transaksi');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
    }

    public function list()
    {
        try {
            $data = Sale::select(
                'id',
                'transaction_time',
            )->get();
            if ($data) {
                return $this->sendResponse($data, 'Menampilkan list transaksi');
            } else {
                throw new \Exception("Error, undefined type");
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
    }
}
