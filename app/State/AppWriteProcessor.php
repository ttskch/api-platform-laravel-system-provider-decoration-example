<?php

declare(strict_types=1);

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Processor\WriteProcessor;
use ApiPlatform\State\ProcessorInterface;

final class AppWriteProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly mixed $decorated,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        assert($this->decorated instanceof WriteProcessor);
        
        return $this->decorated->process($data, $operation, $uriVariables, $context);
    }
}
