<?php

use Illuminate\Pipeline\Pipeline;
use Skillcraft\PsychicFishstick\Abstracts\BasePipeline;

// Create a concrete implementation of BasePipeline for testing
class TestPipeline extends BasePipeline
{
    protected mixed $data;

    public function __construct(mixed $data)
    {
        $this->data = $data;
    }

    protected function getInitialData(): mixed
    {
        return $this->data;
    }

    protected function pipes(): array
    {
        return [
            // Simple pipes for testing
            new class {
                public function handle($data, \Closure $next)
                {
                    $data['step1'] = true;
                    return $next($data);
                }
            },
            new class {
                public function handle($data, \Closure $next)
                {
                    $data['step2'] = true;
                    return $next($data);
                }
            },
        ];
    }
}

it('processes data through the defined pipeline steps', function () {
    // Mock data to process
    $data = ['name' => 'John Doe'];

    // Instantiate the test pipeline with the mock data
    $pipeline = new TestPipeline($data);

    // Execute the pipeline
    $result = $pipeline->execute();

    // Assertions
    expect($result)
        ->toBeArray()
        ->toMatchArray([
            'name' => 'John Doe',
            'step1' => true,
            'step2' => true,
        ]);
});
