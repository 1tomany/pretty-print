<?php

namespace OneToMany\PrettyPrint;

use function count;
use function is_array;
use function is_bool;
use function is_float;
use function is_int;
use function is_null;
use function is_object;
use function is_string;
use function max;
use function spl_object_id;
use function strlen;
use function substr;
use function trim;

/**
 * Formats a value in PHP as a string that can be safely displayed.
 *
 * @param mixed $value         The value to pretty print
 * @param int $maxStringLength Strings longer than this value will be
 *                             truncated and appended with three periods
 */
function pretty_print(mixed $value, int $maxStringLength = 128): string
{
    $maxStringLength = max(1, $maxStringLength);

    // if ($maxStringBytes > )

    if (is_null($value)) {
        return 'null';
    }

    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }

    if (is_int($value)) {
        return (string) $value;
    }

    if (is_float($value)) {
        return (string) $value;
    }

    if (is_string($value) && strlen($value) > $maxStringLength) {
        $value = trim(substr($value, 0, $maxStringLength)).'...';
    }

    if (is_array($value)) {
        list($index, $count) = [
            0, count($value) - 1,
        ];

        $pretty = '[';

        foreach ($value as $k => $v) {
            if (is_string($k)) {
                $pretty = $pretty.$k.' => ';
            }

            // Clean each value of the array, and append a comma if needed
            $pretty = $pretty.pretty_print($v).($index++ < $count ? ', ' : '');
        }

        $pretty = $pretty.']';

        return $pretty;
    }

    if (is_object($value)) {
        return 'object<'.spl_object_id($value).'>';
    }

    return is_string($value) ? '"'.$value.'"' : 'unknown';
}
