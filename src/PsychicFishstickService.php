<?php

namespace Skillcraft\PsychicFishstick;

use Skillcraft\PsychicFishstick\Pipelines\GenericPipeline;

class PsychicFishstickService
{
    /**
     * Execute a pipeline with the given data and pipes.
     *
     * @param mixed $data The initial data to process.
     * @param array $pipes An array of pipes to execute.
     * @return mixed The processed result.
     */
    public static function process(mixed $data, array $pipes): mixed
    {
        return (new GenericPipeline($data, $pipes))->execute();
    }
}
