<?php

declare(strict_types=1);

namespace TomasVotruba\Lavarle\Tests\Functions\src;

use TomasVotruba\Lavarle\Tests\Functions\src\Contract\TinyServiceInterface;

final class MainService
{
    /**
     * @param TinyServiceInterface[] $tinyServices
     */
    public function __construct(
        private readonly array $tinyServices
    ) {
    }

    /**
     * @return TinyServiceInterface[]
     */
    public function getTinyServices(): array
    {
        return $this->tinyServices;
    }
}
