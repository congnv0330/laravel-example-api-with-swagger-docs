<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UploadService
{
    public function upload(UploadedFile $file): JsonResponse
    {
        $path = $file->store(
            'uploads/' . date('Y') . '/' . date('m') . '/' . date('d')
        );

        return response()->json([
            'path' => Storage::url($path)
        ]);
    }
}
