<?php

declare(strict_types=1);

namespace App\Utils\Helper;

use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

/**
 * Class ClassHelper
 */
class ClassHelper
{
    /**
     * @param string $namespace
     *
     * @return array
     */
    public static function loadClasses(string $namespace): array
    {
        $namespacePath = static::translateNamespacePath($namespace);

        if ('' === $namespacePath) {
            return [];
        }

        return self::searchClasses($namespace, $namespacePath);
    }

    /**
     * @param string $namespace
     *
     * @return string
     */
    protected static function translateNamespacePath(string $namespace): string
    {
        $rootPath = 'src/';

        $nsParts = explode('\\', $namespace);
        array_shift($nsParts);

        if (empty($nsParts)) {
            return '';
        }

        return realpath($rootPath.implode(DIRECTORY_SEPARATOR, $nsParts)) ?: '';
    }

    /**
     * @param string $namespace
     * @param string $namespacePath
     *
     * @return array
     */
    private static function searchClasses(string $namespace, string $namespacePath): array
    {
        $classes = [];

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($namespacePath, FilesystemIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );

        /** @var SplFileInfo $item */
        foreach ($iterator as $item) {
            if ($item->isDir()) {
                $nextPath = $iterator->current()->getPathname();
                $nextNamespace = $namespace.'\\'.$item->getFilename();
                $classes = array_merge($classes, self::searchClasses($nextNamespace, $nextPath));

                continue;
            }

            if ($item->isFile() && 'php' === $item->getExtension()) {
                $class = $namespace.'\\'.$item->getBasename('.php');
                if (!class_exists($class)) {
                    continue;
                }

                $classes[] = $class;
            }
        }

        return $classes;
    }
}
