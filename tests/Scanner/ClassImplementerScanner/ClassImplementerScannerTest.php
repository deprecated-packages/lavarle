<?php

declare(strict_types=1);

namespace TomasVotruba\Lavarle\Tests\Scanner\ClassImplementerScanner;

use PHPUnit\Framework\Attributes\DoesNotPerformAssertions;
use PHPUnit\Framework\TestCase;
use TomasVotruba\Lavarle\Scanner\ClassImplementerScanner;
use TomasVotruba\Lavarle\Tests\Scanner\ClassImplementerScanner\Fixture\SomeInterface;

final class ClassImplementerScannerTest extends TestCase
{
    public function test(): void
    {
        $classImplementers = ClassImplementerScanner::findImplementers(
            [__DIR__ . '/Fixture'],
            SomeInterface::class
        );

        $this->assertCount(1, $classImplementers);
    }

    #[DoesNotPerformAssertions]
    public function testIgnoreNonExistingDirectory(): void
    {
        ClassImplementerScanner::findImplementers(
            [__DIR__ . '/missing'],
            SomeInterface::class
        );
    }
}
