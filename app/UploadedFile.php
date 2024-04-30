<?php

namespace App;

class UploadedFile
{
    public function __construct(private array $file)
    {
    }

    public function save(string $path = null, string $filename = null)
    {
        $info = pathinfo($this->file['name']);
        $ext = $info['extension'];
        $target = realpath('storage')."/".($path ?? '')."/".($filename ?? randomStr()).".$ext";
        $target = str_replace("//","/",$target);
        move_uploaded_file($this->file['tmp_name'], $target);
        return $target;
    }
}