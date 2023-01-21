<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ResponseController extends Controller
{
    public function response(Request $request): Response
    {
        return response("hello response");
    }

    public function header(Request $request): Response
    {
        $body = [
            'firstName' => 'Evan',
            'lastName' => 'Pangau'
        ];

        return response(json_encode($body), 200)
            ->header('Content-Type', 'application/json')
            ->withHeaders([
                'Author' => 'Stevanus Pangau',
                'App' => 'Belajar Laravel'
            ]);
    }

    // Response view
    public function responseView(Request $request): Response
    {
        return response()->view('hello', ['name' => 'Evan']);
    }

    // Response untuk data json
    public function responseJson(Request $request): JsonResponse
    {
        $body = [
            'firstName' => 'Evan',
            'lastName' => 'Pangau'
        ];
        return response()->json($body);
    }

    // Reponse untuk mengambil file
    public function responseFile(Request $request): BinaryFileResponse
    {
        return response()->file(storage_path('app/public/pictures/evan.png'));
    }

    // Reponse untuk dipaksa download file
    public function responseDownload(Request $request): BinaryFileResponse
    {
        return response()->download(storage_path('app/public/pictures/evan.png'));
    }
}
