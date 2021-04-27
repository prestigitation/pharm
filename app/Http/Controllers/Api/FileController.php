<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function updateFile(Request $request,$section,$id) {
        if($request->hasFile('file')) {
            Storage::putFileAs('./public/img/'.$section.'/',$request->file('file'),(string) $id .'.jpeg');
        }
    }

    /** TODDOOOOOOO */

    public function uploadFile(Request $request,$section,$id) {

    }

    public function getStoragePath() {
        return storage_path();
    }
}
