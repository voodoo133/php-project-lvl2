<?php

namespace Differ\Differ\Formatters\Plain;

function format(array $diff)
{
    $iter = function ($currDiff, $keys) use (&$iter) {
        $lines = array_map(function ($val) use ($iter, $keys) {
            [
                'name'      => $name,
                'type'      => $type,
                'prevValue' => $prevValue,
                'newValue'  => $newValue,
                'children'  => $children,
            ] = $val;

            $keysList = [...$keys, $name];
            $fullName = join('.', $keysList);

            $prevValueStr = valueToString($prevValue);
            $newValueStr = valueToString($newValue);

            switch ($type) {
                case 'added':
                    return "Property '{$fullName}' was added with value: {$newValueStr}";

                case 'removed':
                    return "Property '{$fullName}' was removed";

                case 'changed':
                    return "Property '{$fullName}' was updated. From {$prevValueStr} to {$newValueStr}";

                case 'not-changed':
                    return null;

                case 'nested':
                    return $iter($children, $keysList);
            }
        }, $currDiff);

        $filteredLines = array_filter($lines, fn($str) => !is_null($str));

        return join("\n", $filteredLines);
    };

    return $iter($diff, []);
}


function valueToString(mixed $val)
{
    switch (true) {
        case is_bool($val):
            return var_export($val, true);

        case is_null($val):
            return 'null';

        case is_object($val):
            return '[complex value]';

        case is_string($val):
            return "'${val}'";

        default:
            return strval($val);
    }
}
