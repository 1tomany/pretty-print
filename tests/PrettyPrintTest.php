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

    public static function providerValueAndPrettyValue(): array
    {
        $provider = [
            [null, 'null'],
        ];

        return $provider;
    }
}
