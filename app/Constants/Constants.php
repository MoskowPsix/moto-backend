<?php

namespace App\Constants;

use ReflectionClass;

class Constants
{
    public static function getConstants(): array
    {
        $reflection = new ReflectionClass(get_called_class());
        return $reflection->getConstants();
    }

    public static function searchForValue($value): array | null
    {
        $constants = self::getConstants();
        $results = [];

        foreach ($constants as $constantName => $constantValue) {
            if ($constantValue === $value) {
                $results[] = $constantName;
            }
        }
        if (empty($results)){
            return null;
        }
        return $results;
    }
}
