<?php

declare(strict_types=1);

namespace Framework\Templating\Blade;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;

class InMemoryFilesystem extends Filesystem
{
    /** @var array<string, string> */
    private array $files = [];

    public function exists($path)
    {
        return array_key_exists($path, $this->files);
    }

    public function get($path, $lock = false): string
    {
        if (!$this->exists($path)) {
            throw new FileNotFoundException("File does not exist at path {$path}.");
        }
        return $this->files[$path];
    }

    public function put($path, $contents, $lock = false): bool
    {
        $this->files[(string) $path] = (string) $contents;

        return true;
    }

    public function lastModified($path): int
    {
        return 0;
    }

    public function makeDirectory($path, $mode = 0755, $recursive = false, $force = false): bool
    {
        return true;
    }

    public function getRequire($path, array $data = [])
    {
        if ($this->exists($path)) {
            $template = $this->get($path);
            $__data = $data;

            return (static function () use ($template, $__data) {
                extract($__data, EXTR_SKIP);

                return eval('?>' . $template);
            })();
        }

        throw new FileNotFoundException("File is not loaded: {$path}.");
    }
}
