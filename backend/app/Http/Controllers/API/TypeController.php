<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiBaseController;
use App\Http\Controllers\Controller;
use App\Models\Item\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TypeController extends ApiBaseController
{
    // MENAMPILKAN LIST PADA TABEL TYPES DENGAN ATTRIBUTE (REQUEST)
    public function index(Request $request)
    {
        $attributes = $request->all();
        $data = Type::filterQuery($attributes)
            ->paginate(
                isset($attributes['perPage']) ? $attributes['perPage'] : 100,
                ['*'],
                'page',
                isset($attributes['page']) ? $attributes['page'] : 1
            );
        try {
            return $this->sendResponse($data, 'Menampilkan list jenis barang');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    // MEMBUAT DATA BARU PADA TABEL TYPES
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
            ]);
            if ($request->name) {
                DB::beginTransaction();
                $model = new Type();
                $model->name = ucwords($request->name); // Membuat huruf awal pada kata menjadi kapital
                $model->save();
                DB::commit();
                return $this->sendResponse($model, 'Jenis barang berhasil dibuat');
            } else {
                throw new \Exception("Pastikan mengisi nama");
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
            $data = Type::select(
                'id',
                'name',
            )->where('id', $id)->first();
            if ($data) {
                return $this->sendResponse($data, 'Menampilkan detail data jenis barang');
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
                'name' => 'required|string',
            ]);
            $data = Type::find($id);
            if ($data) {
                $data->name = ucwords($request->name);
                $data->save();
            }
            else {
                throw new \Exception("Error, undefined type");
            }
            return $this->sendResponse($data, 'Berhasil memperbaharui data jenis barang');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
    }

    // MENGHAPUS DATA SPESIFIK JENIS BARANG DENGAN PARAMETER (ID)
    public function delete($id)
    {
        try {
            $model = Type::find($id);
            if ($model) {
                $model->delete();
            } else {
                throw new \Exception("Error, undefined type");
            }
            return $this->sendResponse($model, 'Berhasil menghapus data jenis barang');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
    }

    // MENAMPILKAN DATA SPESIFIK JENIS BARANG DENGAN PARAMETER (ID)
    public function list()
    {
        try {
            $data = Type::select(
                'id',
                'name',
            )->get();
            if ($data) {
                return $this->sendResponse($data, 'Menampilkan list data jenis barang');
            } else {
                throw new \Exception("Error, undefined type");
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
    }
}
