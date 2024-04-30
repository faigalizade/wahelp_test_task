<?php

namespace App;

use App\Singleton;
use App\UploadedFile;

class Request extends Singleton
{
    private array $data;
    private array $files;
    private string $method;
    private string $uri;

    public function __construct($data)
    {
        $this->method = $data['method'];
        $this->uri = $data['uri'];
        $this->data = [...$data['get'], ...$data['post'], ...$data['body']];
        if ($data['files']) {
            foreach ($data['files'] as $key => $file) {
                $this->files[$key] = new UploadedFile($file);
            }
        }
    }

    public function get($key): string|array|null
    {
        return $this->data[$key] ?? null;
    }

    public function file(string $key): UploadedFile|null
    {
        return $this->files[$key] ?? null;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getMethod(): string
    {
        return $this->method;
    }
}