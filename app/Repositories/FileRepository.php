<?php

namespace App\Repositories;

use App\Interfaces\FileInterface;
use App\Models\File;
use Illuminate\Support\Facades\Storage;

class FileRepository implements FileInterface
{
    public function uploadFile($groupeId, $file)
    {
        $path = $file->store('uploads'); // Store in "storage/app/uploads"
        
        return File::create([
            'filename' => $file->getClientOriginalName(),
            'path' => $path,
            'groupe_id' => $groupeId,
        ]);
    }

    public function listFiles($groupeId)
    {
        return File::where('groupe_id', $groupeId)->get();
    }
}