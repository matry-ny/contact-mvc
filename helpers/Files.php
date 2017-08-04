<?php

namespace helpers;

/**
 * Class Files
 * @package helpers
 */
class Files
{
    /**
     * @param string $directory
     * @return array
     */
    public static function getDirectoryContent($directory)
    {
        $skip = ['.', '..', '.gitignore'];
        $content = scandir($directory);

        return array_diff($content, $skip);
    }

    /**
     * @param string $dir
     * @param string $file
     * @param string $content
     * @return int
     */
    public static function create($dir, $file, $content)
    {
        $rout = rtrim($dir, '/\\') . DIRECTORY_SEPARATOR . ltrim($file, '/\\');
        return file_put_contents($rout, $content);
    }
}
