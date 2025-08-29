<?php

namespace OneToMany\PrettyPrint;

use function count;
use function get_class;
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
 * While this method will work on any PHP value, it is most useful
 * for null, scalar, and array values. Actual string values will
 * be surrounded by double quotes to highlight zero-length values.
 *
 * Generally, objects will return a string formatted as `FCQN<$objectId>`
 * where `$objectId` is the value returned by `spl_object_id()`. However,
 * `\DateTimeInterface` instances will be formatted using ISO-8601.
 *
 * @param mixed $value The value to pretty print
 * @param int $maxStringLength Strings longer than this value will be truncated and appended with three periods. This value is clamped to the range [128, 4096].
 *
 * @see https://www.php.net/manual/en/class.datetimeinterface.php#datetimeinterface.constants.atom
 */
function pretty_print(mixed $value, int $maxStringLength = 256): string
{
    $maxStringLength = min(max(128, $maxStringLength), 4096);

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
        $value = (string) $value;

        // PHP strips all decimal information when converting floating
        // point values to strings if the value has only zeros in the
        // decimal. For example, (string) 1.0 returns the value "1"
        // instead of "1.0". Thus, if the string representations of a
        // value as an integer and float are the same, we tack on a ".0"
        // to indicate the number is a float. This is much faster than
        // having to instanticate the Locale and NumberFormatter classes.
        return $value === (string)(int) $value ? $value.'.0' : $value;
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
                $pretty .= $k.' => ';
            }

            // Clean each value of the array, and append a comma if needed
            $pretty = $pretty.pretty_print($v).($index++ < $count ? ', ' : '');
        }

        $pretty .= ']';

        return $pretty;
    }

    if ($value instanceof \DateTimeInterface) {
        return $value->format(\DateTimeInterface::ATOM);
    }

    if (is_object($value)) {
        return get_class($value).'<'.spl_object_id($value).'>';
    }

    return is_string($value) ? '"'.$value.'"' : 'unknown';
}
