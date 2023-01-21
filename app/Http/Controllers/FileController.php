<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function upload(Request $request): string
    {
        // $request->allFiles() // untuk mengambil semua file yang di upload
        $picture = $request->file('picture');
        // $picture->path() // untuk melihat lokasi file
        /*
        ->store = untuk menyimpan file dengan nama random
        ->storeAs = untuk menyimpan file dengan nama tertentu
        ->storePubliclyAs = untuk menyimpan file dengan nama tertentu di public
        */
        $picture->storePubliclyAs("pictures", $picture->getClientOriginalName(), "public");

        return "OK " . $picture->getClientOriginalName();
    }
}
