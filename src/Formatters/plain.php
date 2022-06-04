<?php

namespace Differ\Differ\Formatters\Plain;

function format($diff)
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

            $keys[] = $name;
            $fullName = join('.', $keys);

            $prevValue = valueToString($prevValue);
            $newValue = valueToString($newValue);

            switch ($type) {
                case 'added':
                    return "Property '{$fullName}' was added with value: {$newValue}";
                    break;

                case 'removed':
                    return "Property '{$fullName}' was removed";
                    break;

                case 'changed':
                    return "Property '{$fullName}' was updated. From {$prevValue} to {$newValue}";
                    break;

                case 'not-changed':
                    return null;
                    break;

                case 'nested':
                    return $iter($children, $keys);
            }
        }, $currDiff);

        $lines = array_filter($lines, fn($str) => !is_null($str));

        return join("\n", $lines);
    };

    return $iter($diff, []);
}


function valueToString($val)
{
    switch (true) {
        case is_bool($val):
            return var_export($val, true);
            break;

        case is_null($val):
            return 'null';
            break;

        case is_object($val):
            return '[complex value]';

            break;

        case is_string($val):
            return "'${val}'";

            break;

        default:
            return strval($val);
            break;
    }
}
