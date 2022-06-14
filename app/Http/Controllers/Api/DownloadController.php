<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DownloadController extends Controller
{
    public function repository()
    {
        $owner = env('GITHUB_OWNER', 'TaufiqStark');
        $repo = env('GITHUB_REPO', 'portfolio-tailwind');
        $branch = env('GITHUB_BRANCH', 'main');
        $archive_format = env('GITHUB_ARCHIVE_FORMAT', 'zipball');
        $response = Http::get('https://api.github.com/repos/'.$owner.'/'.$repo.'/'.$archive_format.'/'.$branch);
        $response->onError(function ($msg){
            return response()->json(['message' => $msg || 'failed'], 500);
        });
        $response->throw()->json();
        if($response->failed()){
            return response()->json(['message' => 'failed']);
        }
        return response($response)->header('Content-Type', 'application/zip');
    }
}
