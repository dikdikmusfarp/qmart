<?php

namespace App\Http\Controllers;

use App\Models\LogError;
use Illuminate\Http\Request;


class ApiBaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResponse($result, $message = 'success')
    {
        $response = [
            'status' => true,
            'message' => $message,
            'data'    => $result,
        ];


        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendError($error, $errorMessages = [], $code = 500)
    {
        $attributes = request()->all();
        $route = request()->path();
        $response = [
            'status' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['error'] = $errorMessages;
        }

        // if (isset(getUser()->type) && !empty(getUser()->type)) {
        //     LogError::create([
        //         'model' => $this->getModelByType(getUser()->type),
        //         'entity_id' => getUser()->id,
        //         'code' => $code,
        //         'message' => $response['message'],
        //         'error' => isset($response['error']) ? is_array($response['error']) ? json_encode($response['error']) : $response['error'] : null,
        //         'payload' => (count($attributes) > 0) ? json_encode($attributes) : null,
        //         'route' => $route
        //     ]);
        // }

        return response()->json($response, $code);
    }

    /**
     * @OA\SecurityScheme(
     *    securityScheme="bearerAuth",
     *    in="header",
     *    name="bearerAuth",
     *    type="http",
     *    scheme="bearer",
     *    description="Enter token in format (Bearer <token>)",
     * ),
     */
    public function getModelByType($type)
    {
        if ($type === 'general') {
            return 'App\Models\User';
        } elseif ($type === 'komite') {
            return 'App\Models\Master\Komite';
        } elseif ($type === 'siswa') {
            return 'App\Models\Master\Siswa';
        } elseif ($type === 'pegawai') {
            return 'App\Models\Master\Pegawai';
        } elseif ($type === 'operator') {
            return 'App\Models\Master\Operator';
        }

        return null;
    }

    /**
     * Pagination Mapping
     * @param $data
     * @param $query
     * @param bool $source
     * @return void
     */
    public function paginationMap(&$data, $query, $request, $id = 'id')
    {
        if ($request->source)
            $data = $query->get();
        else {
            $orderDirection = $request->order_direction ?? 'ASC';
            $orderName = $request->order_column ?? $id;

            $data = $query->orderByRaw($orderName . " " . $orderDirection)
                ->paginate(
                    $request->perPage ?? 10,
                    ['*'],
                    'page',
                    $request->page ?? 1
                );
        }
    }
}
