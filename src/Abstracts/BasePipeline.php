<?php

namespace Skillcraft\PsychicFishstick\Abstracts;

use Illuminate\Pipeline\Pipeline;

abstract class BasePipeline
{
    /**
     * Get the initial data to be processed by the pipeline.
     */
    abstract protected function getInitialData(): mixed;

    /**
     * Define the sequence of pipes (steps).
     */
    abstract protected function pipes(): array;

    /**
     * Execute the pipeline and return the final result.
     */
    public function execute(): mixed
    {
        return app(Pipeline::class)
            ->send($this->getInitialData())
            ->through($this->pipes())
            ->thenReturn();
    }
}
