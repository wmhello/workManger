<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/30 0030
 * Time: 10:48
 */

namespace App\Http\Controllers;

trait Result
{
    public function success()
    {
         return response()->json([
           'status' => 'success',
           'status_code' => 200
        ], 200);
    }

    public function error()
    {
        return response()->json([
            'status' => 'error',
            'status_code' => 404
        ], 404);
    }

    public function validateError($errors)
    {
        return response()->json(
            [
                'status' => 'validate error',
                'status_code' => 422,
                'errors' => $errors
            ], 422);
    }

    public function errorWithInfo( $info)
    {
        return response()->json([
            'status' => 'error',
            'status_code' => 404,
            'message' => $info
        ], 404);

    }
}