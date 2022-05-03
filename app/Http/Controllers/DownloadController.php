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
        // 預設下載檔案檔名為虛擬主機上的原始檔案檔名
        if ($name === null) {
            $name = strpos($path, '/') === false ? substr(strrchr($path, '\\'), 1) : substr(strrchr($path, '/'), 1);
        }

        return response()->download($path, $name);
    }
}
