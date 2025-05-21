<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GoogleDriveController extends Controller
{
    public function uploadFile(Request $request)
    {


        return response()->json(['message' => 'Archivo subido correctamente']);
    }
}
