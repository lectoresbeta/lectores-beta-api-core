<?php

namespace BetaReaders\Utils;

if (!function_exists('snakeToCamel')) {
    function snakeToCamel(string $word): string
    {
        return lcfirst(str_replace('_', '', ucwords($word, '_')));
    }
}

if (!function_exists('camelToSnake')) {
    function camelToSnake(string $word): string
    {
        return ctype_lower($word)
            ? $word
            : strtolower(preg_replace('/([^A-Z\s])([A-Z])/', '$1_$2', $word));
    }
}

if (!function_exists('jsonDeserialize')) {
    function jsonDeserialize(string $json, int $depth = 512): array
    {
        $array = json_decode($json, true, $depth);

        if (JSON_ERROR_NONE == json_last_error()) {
            return $array;
        }

        throw new \RuntimeException(json_last_error_msg());
    }
}

if (!function_exists('jsonSerialize')) {
    function jsonSerialize(array $data): string
    {
        $json = json_encode($data);

        if (JSON_ERROR_NONE == json_last_error()) {
            return $json;
        }

        throw new \RuntimeException(json_last_error_msg());
    }
}

if (!function_exists('unless')) {
    function unless(bool $condition, mixed $onConditionMet, mixed $default = null): mixed
    {
        if ($condition) {
            return $onConditionMet;
        }

        return $default;
    }
}
