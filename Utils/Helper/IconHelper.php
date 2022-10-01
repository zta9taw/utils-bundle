<?php

declare(strict_types=1);

namespace App\Utils\Helper;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Class IconHelper
 */
class IconHelper
{
    const OTHER_TYPE = 'other';
    const RISK_TYPE = 'risk';
    const CHEMICAL_PRODUCT = 'chemical_product';

    /**
     * @var array
     */
    private static array $icons = [];

    /**
     * @var bool
     */
    private static bool $iconsLoaded = false;

    /**
     * @param string $type
     * @param bool   $includeOthers
     *
     * @return array
     */
    public static function getIcons(string $type, bool $includeOthers = false): array
    {
        static::loadIcons();

        if (!$includeOthers) {
            return static::$icons[$type] ?? [];
        }

        return array_merge(static::$icons[$type] ?? [], static::$icons[static::OTHER_TYPE]);
    }

    /**
     * Load icons from folder.
     */
    private static function loadIcons(): void
    {
        if (static::$iconsLoaded) {
            return;
        }

        $finder = new Finder();
        $finder
            ->files()
            ->in(realpath('./build/common/icons'))
            ->name('*.svg')
        ;

        /** @var SplFileInfo $file */
        foreach ($finder as $file) {
            $name = str_replace('.svg', '', $file->getBasename());
            if (empty($file->getRelativePath())) {
                static::$icons[static::OTHER_TYPE][] = $name;

                continue;
            }

            static::$icons[$file->getRelativePath()][] = $name;
        }

        static::$iconsLoaded = true;
    }
}
