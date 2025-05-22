<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
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

            // Obtener el nombre del archivo
            $file_name =  $request->file('file')->getClientOriginalName();

            // Obtener la extensión del archivo
            $extension = pathinfo($file_name, PATHINFO_EXTENSION);
            // Obtener el tipo de archivo
            $type = "photo";
            if ($extension === 'mp4') {
                $type = "video";
            }
            // Generar el nombre del archivo
            $file_name = $type . '_' . date('Y-m-d_His') . '.' . $extension;

            // Subir el archivo
            Gdrive::put($file_name, $request->file('file'));

            // Respuesta de éxito
            return response()->json([
                'status' => true,
                'file_name' => env('GOOGLE_DRIVE_FOLDER') . '/' . $file_name,
                'message' => 'File uploaded successfully!'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while uploading the file',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    public function showFile(Request $request, string $name)
    {
        try {
            // Intentar obtener el archivo desde Gdrive
            $image = Gdrive::get($name);

            // Responder con el archivo y su tipo de contenido
            return response($image->file, 200)
                ->header('Content-Type', $image->ext);
        } catch (\Exception $e) {
            // Responder con un mensaje de error genérico
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while retrieving the file',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    public function deleteFile(Request $request, string $name)
    {
        try {

            // Intentar eliminar el archivo desde Gdrive
            Gdrive::delete($name);

            // Responder con éxito
            return response()->json([
                'status' => true,
                'file_name' => $name,
                'message' => 'File deleted successfully!'
            ], 200);
        } catch (\Exception $e) {
            // Responder con un mensaje de error genérico
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while deleting the file',
                'details' => $e->getMessage(),
            ], 500);
        }
    }
}
