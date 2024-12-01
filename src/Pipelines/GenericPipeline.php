<?php

namespace Skillcraft\PsychicFishstick\Pipelines;

use Illuminate\Pipeline\Pipeline;

class GenericPipeline
{
    protected mixed $data;
    protected array $pipes;

    public function __construct(mixed $data, array $pipes)
    {
        $this->data = $data;
        $this->pipes = $pipes;
    }

    public function execute(): mixed
    {
        return app(Pipeline::class)
            ->send($this->data)
            ->through($this->pipes)
            ->thenReturn();
    }
}
