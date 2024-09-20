<?php

namespace App\Interfaces;

interface FileInterface
{
    public function uploadFile($groupeId, $file);
    public function listFiles($groupeId);
}