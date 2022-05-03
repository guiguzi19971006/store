<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    /**
     *  下載檔案
     * 
     *  @param string $path
     *  @param string|null $name
     * 
     *  @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download(string $path, ?string $name = null)
    {
        return response()->download($path, $name);
    }
}
