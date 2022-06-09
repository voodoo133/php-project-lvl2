<?php

namespace Differ\Differ\Formatters\Stylish;

function format(array $diff)
{
    $iter = function ($currDiff, $depth) use (&$iter) {
        $closeBracketIndent = makeIndent($depth - 1);

        $lines = array_map(function ($val) use ($iter, $depth) {
            [
                'name'      => $name,
                'type'      => $type,
                'prevValue' => $prevValue,
                'newValue'  => $newValue,
                'children'  => $children,
            ] = $val;

            $unchangedIndent    = makeIndent($depth);
            $changedIntent      = substr($unchangedIndent, 0, -2);

            switch ($type) {
                case 'added':
                    return "{$changedIntent}+ {$name}: " . valueToString($newValue, $depth);

                case 'removed':
                    return "{$changedIntent}- {$name}: " . valueToString($prevValue, $depth);

                case 'not-changed':
                    return "{$unchangedIndent}{$name}: " . valueToString($prevValue, $depth);

                case 'changed':
                    $removedStr = "{$changedIntent}- {$name}: " . valueToString($prevValue, $depth);
                    $addedStr = "{$changedIntent}+ {$name}: " . valueToString($newValue, $depth);
                    return "{$removedStr}\n{$addedStr}";

                case 'nested':
                    return "{$unchangedIndent}{$name}: " . $iter($children, $depth + 1);
            }
        }, $currDiff);

        $result = ["{", ...$lines, "{$closeBracketIndent}}"];

        return join("\n", $result);
    };

    return $iter($diff, 1);
}

function makeIndent(int $depth)
{
    return str_repeat(" ", 4 * $depth);
}

function valueToString(mixed $val, int $depth)
{
    switch (true) {
        case is_bool($val):
            return var_export($val, true);

        case is_null($val):
            return 'null';

        case is_object($val):
            $indent = makeIndent($depth + 1);
            $closeBracketIndent = makeIndent($depth);

            $keys = array_keys(get_object_vars($val));

            $lines = array_map(function ($k) use ($val, $indent, $depth) {
                return "{$indent}{$k}: " . valueToString($val->$k, $depth + 1);
            }, $keys);

            $result = ["{", ...$lines, "{$closeBracketIndent}}"];

            return join("\n", $result);

        default:
            return strval($val);
    }
}
