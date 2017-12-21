<?php

namespace App\Http\Controllers\Import;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class SessionImport extends Controller implements Import
{
    //
    public function importData($file)
    {

        $filePath = storage_path('app').'/'.$file;
        Excel::load($filePath, function($reader) {
            $data = $reader->first()->toArray();
            dd($data);
        });
    }
}
