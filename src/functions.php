<?php

declare(strict_types=1);

namespace TomasVotruba\Lavarle;

use Illuminate\Container\RewindableGenerator;
use Illuminate\Contracts\Foundation\Application;
use Nette\Loaders\RobotLoader;

/**
 * @param string[] $directories
 * @param class-string $interface
 */
function tag_directory_by_interface(
    array $directories,
    Application $application,
    string $interface
): void {
    $robotLoader = new RobotLoader();
    $robotLoader->addDirectory(...$directories);
    $robotLoader->setTempDirectory(sys_get_temp_dir() . '/laravel-robot-loader');
    $robotLoader->refresh();

    collect($robotLoader->getIndexedClasses())
        ->keys()
        ->reject(static fn (string $class): bool => $class === $interface)
        ->filter(static fn (string $class): bool => is_a($class, $interface, true))
        ->each(static fn (string $class) => $application->singleton($class))
        ->each(static fn (string $class) => $application->tag([$class], $interface));
}

/**
 * @template TType as object
 * @param class-string<TType> $type
 * @return TType[]
 */
function autowire_by_type(string $type): array
{
    tag_directory_by_interface([
        base_path('app'),
        base_path('packages'),
        base_path('src'),
    ], app(), $type);

    /** @var RewindableGenerator<TType> $taggedIterator */
    $taggedIterator = app()->tagged($type);
    return iterator_to_array($taggedIterator);
}
