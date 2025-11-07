<?php

namespace App\Http\Controllers;

use Facade\FlareClient\Http\Response;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiCntroller extends Controller
{
    public function data_product()
    {
        try {
            $category = DB::table('log_m_product')->inRandomOrder()->limit(10)->get();
            return response()->json($category);
        } catch (QueryException $e) {
            $error = [
                'error' => $e->getMessage()
            ];
            return response()->json($error, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function data_antrian()
    {

        $data_arr = array(
            "loket1" => "A015",
            "loket2" => "B004",
            // "loket3" => "Z021"
        );
        return response()->json($data_arr);
    }
}
