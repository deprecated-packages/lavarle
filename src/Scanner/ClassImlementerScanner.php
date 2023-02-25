<?php

declare(strict_types=1);

namespace TomasVotruba\Lavarle\Scanner;

use Nette\Loaders\RobotLoader;
use Webmozart\Assert\Assert;

/**
 * @see \TomasVotruba\Lavarle\Tests\Scanner\ClassImplementerScanner\ClassImplementerScannerTest
 */
final class ClassImlementerScanner
{
    /**
     * @param string[] $directories
     * @return string[]
     */
    public static function findImplementers(array $directories, string $interfaceClass): array
    {
        $existingDirectories = array_filter($directories, 'file_exists');
        if ($existingDirectories === []) {
            return [];
        }

        $robotLoader = new RobotLoader();
        $robotLoader->addDirectory(...$existingDirectories);
        $robotLoader->setTempDirectory(sys_get_temp_dir() . '/laravel-robot-loader');
        $robotLoader->refresh();

        $classes = array_keys($robotLoader->getIndexedClasses());

        $implementerClasses = collect($classes)
            // skip itself
            ->filter(static fn (string $class): bool => $class !== $interfaceClass)
            ->filter(static fn (string $class): bool => is_a($class, $interfaceClass, true))
            ->toArray();

        Assert::allString($implementerClasses);

        return $implementerClasses;
    }
}
