<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    /**
     *  下載指定檔案
     * 
     *  @param string $path
     *  @param string|null $name
     * 
     *  @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download_file(string $path, ?string $name = null)
    {
        // 預設下載檔案檔名為虛擬主機上的原始檔案檔名
        if ($name === null) {
            $name = substr(strrchr($path, '/'), 1);
        }

        return response()->download(Storage::disk('photos')->get('product/' . $path), $name);
    }
}
