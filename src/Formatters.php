<?php

namespace GenDiff\Formatters;

function format($diff, $type = 'stylish')
{
    switch ($type) {
        case 'stylish':
        default:
            return stylishFormat($diff);
    }
}

function stylishFormat($diff)
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
                    break;

                case 'removed':
                    return "{$changedIntent}- {$name}: " . valueToString($prevValue, $depth);
                    break;

                case 'not-changed':
                    return "{$unchangedIndent}{$name}: " . valueToString($prevValue, $depth);
                    break;

                case 'changed':
                    $removedStr = "{$changedIntent}- {$name}: " . valueToString($prevValue, $depth);
                    $addedStr = "{$changedIntent}+ {$name}: " . valueToString($newValue, $depth);
                    return "{$removedStr}\n{$addedStr}";
                    break;

                case 'nested':
                    return "{$unchangedIndent}{$name}: " . $iter($children, $depth + 1);
            }
        }, $currDiff);

        $result = ["{", ...$lines, "{$closeBracketIndent}}"];

        return join("\n", $result);
    };

    return $iter($diff, 1);
}

function makeIndent($depth)
{
    return str_repeat(" ", 4 * $depth);
}

function valueToString($val, $depth)
{
    switch (true) {
        case is_bool($val):
            return var_export($val, true);
            break;

        case is_null($val):
            return 'null';
            break;

        case is_object($val):
            $indent = makeIndent($depth + 1);
            $closeBracketIndent = makeIndent($depth);

            $keys = array_keys(get_object_vars($val));

            $lines = array_map(function ($k) use ($val, $indent, $depth) {
                return "{$indent}{$k}: " . valueToString($val->$k, $depth + 1);
            }, $keys);

            $result = ["{", ...$lines, "{$closeBracketIndent}}"];

            return join("\n", $result);

            break;

        default:
            return strval($val);
            break;
    }
}
