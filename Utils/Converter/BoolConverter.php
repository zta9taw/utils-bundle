<?php

declare(strict_types=1);

namespace Zta9taw\Bundle\UtilsBundle\Utils\Converter;

class BoolConverter
{
    public static function getBoolValue(mixed $value): ?bool
    {
        if (is_bool($value)) {
            return $value;
        }

        if (is_string($value)) {
            $value = strtolower($value);
        }

        if (in_array($value, ['1', 'true', 1], true)) {
            return true;
        }

        if (in_array($value, ['0', 'false', 0], true)) {
            return false;
        }

        return null;
    }
}
