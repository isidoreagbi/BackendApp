<?php

namespace App\Http\Controllers;

use App\Interfaces\FileInterface;
use App\Http\Requests\UploadFileRequest;
use Illuminate\Http\Request;

class FileController extends Controller
{
    protected $fileRepo;

    public function __construct(FileInterface $fileRepo)
    {
        $this->fileRepo = $fileRepo;
    }

    public function upload(UploadFileRequest $request, $groupeId)
    {
        $file = $request->file('file');
        $uploadedFile = $this->fileRepo->uploadFile($groupeId, $file);

        return response()->json(['message' => 'File uploaded successfully.', 'file' => $uploadedFile], 201);
    }

    public function list($groupeId)
    {
        $files = $this->fileRepo->listFiles($groupeId);

        return response()->json($files);
    }
}