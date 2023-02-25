<?php

declare(strict_types=1);

namespace TomasVotruba\Lavarle\Tests\Functions;

use Illuminate\Foundation\Application;
use PHPUnit\Framework\TestCase;
use TomasVotruba\Lavarle\Tests\Functions\src\Contract\TinyServiceInterface;
use TomasVotruba\Lavarle\Tests\Functions\src\MainService;
use function TomasVotruba\Lavarle\autowire_by_type;

final class AutowireByTypeTest extends TestCase
{
    private Application $application;

    protected function setUp(): void
    {
        $application = new Application(__DIR__);

        $application->singleton(
            MainService::class,
            static fn (Application $application): MainService => new MainService(
                autowire_by_type(TinyServiceInterface::class),
            )
        );

        $this->application = $application;
    }

    public function test(): void
    {
        $mainService = $this->application->make(MainService::class);

        $tinyServices = $mainService->getTinyServices();
        $this->assertCount(2, $tinyServices);
    }
}
