<?php

declare(strict_types=1);

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Processor\WriteProcessor;
use ApiPlatform\State\ProcessorInterface;
use App\Attribute\SkipAutoconfigure;

#[SkipAutoconfigure]
final class AppWriteProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly mixed $decorated,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        assert($this->decorated instanceof WriteProcessor);

        // whether the CallableProcessor owned by WriteProcessor includes AppWriteProcessor, which is a system provider
        $callableProcessorRef = new \ReflectionProperty($this->decorated, 'callableProcessor');
        $callableProcessor = $callableProcessorRef->getValue($this->decorated);
        $locatorRef = new \ReflectionProperty($callableProcessor, 'locator');
        $locator = $locatorRef->getValue($callableProcessor);
        $servicesRef = new \ReflectionProperty($locator, 'services');
        $services = $servicesRef->getValue($locator);
        assert(in_array(self::class, array_map(fn (object $service) => $service::class, array_values($services)), true) === false);

        return $this->decorated->process($data, $operation, $uriVariables, $context);
    }
}
