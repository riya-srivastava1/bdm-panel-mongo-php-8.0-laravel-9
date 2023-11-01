<?php

namespace App\Http\Controllers\TraitClass;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait FileUploadTrait
{
    public function doFileUpload($path, $file)
    {
        return Storage::disk('do')->put($path, $file, 'public');
    }

    public function doFileUnlink($path)
    {
        Storage::disk('do')->delete($path);
    }
}
