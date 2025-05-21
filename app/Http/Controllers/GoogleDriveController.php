<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yaza\LaravelGoogleDriveStorage\Gdrive;

class GoogleDriveController extends Controller
{

    public function uploadFile(Request $request)
    {


        try {
            // Validar que el archivo está presente
            if (!$request->hasFile('file')) {
                return response()->json([
                    'status' => false,
                    'message' => 'El archivo no esta cargado!'
                ], 400);
            }

            // Obtener nombre del archivo
            $nombreArchivo = $request->file('file')->getClientOriginalName();

            // Subir el archivo
            Gdrive::put($nombreArchivo, $request->file('file'));

            // Respuesta de éxito
            return response()->json([
                'status' => true,
                'message' => 'File uploaded successfully!'
            ], 200);
        } catch (\Exception $e) {
            // Manejo de errores y registro en logs

            return response()->json([
                'error' => 'An error occurred while uploading the file',
                'details' => $e->getMessage(),
            ], 500);
        }
    }
}
