<?php

declare(strict_types=1);

namespace TomasVotruba\Lavarle\Tests\Scanner\ClassImplementerScanner;

use PHPUnit\Framework\TestCase;
use TomasVotruba\Lavarle\Scanner\ClassImlementerScanner;
use TomasVotruba\Lavarle\Tests\Scanner\ClassImplementerScanner\Fixture\SomeInterface;

final class ClassImplementerScannerTest extends TestCase
{
    public function test(): void
    {
        $classImplementers = ClassImlementerScanner::findImplementers(
            [__DIR__ . '/Fixture'],
            SomeInterface::class
        );

        $this->assertCount(1, $classImplementers);
    }
}
