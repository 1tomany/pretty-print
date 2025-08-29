<?php

namespace OneToMany\PrettyPrint\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

use function OneToMany\PrettyPrint\pretty_print;

#[Group('UnitTests')]
final class PrettyPrintTest extends TestCase
{
    #[DataProvider('providerValueAndPrettyValue')]
    public function testPrettyPrint(mixed $value, string $prettyValue): void
    {
        $this->assertSame(pretty_print($value), $prettyValue);
    }

    /**
     * @return list<list<mixed>>
     */
    public static function providerValueAndPrettyValue(): array
    {
        $provider = [
            [null, 'null'],
            [true, 'true'],
            [false, 'false'],
            [0, '0'],
            [1, '1'],
            [-1, '-1'],
            [10, '10'],
            [1.0, '1.0'],
            [1.45, '1.45'],
            [-3.14, '-3.14'],
            ['', '""'],
            ['a', '"a"'],
            ['A', '"A"'],
            ['aA', '"aA"'],
            ['0', '"0"'],
            ['1.0', '"1.0"'],
            [[], '[]'],
            [[null], '[null]'],
            [[true], '[true]'],
            [[false], '[false]'],
            [[0], '[0]'],
            [[1.0], '[1.0]'],
            [['a'], '["a"]'],
        ];

        return $provider;
    }
}
