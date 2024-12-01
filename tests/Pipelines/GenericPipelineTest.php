<?php


use Skillcraft\PsychicFishstick\Pipelines\GenericPipeline;

it('processes data through a generic pipeline', function () {
    $data = ['name' => 'John Doe'];

    $pipes = [
        function ($data, $next) {
            $data['step1'] = 'Processed in Step1';
            return $next($data);
        },
        function ($data, $next) {
            $data['step2'] = 'Processed in Step2';
            return $next($data);
        },
    ];

    $pipeline = new GenericPipeline($data, $pipes);
    $result = $pipeline->execute();

    expect($result)->toMatchArray([
        'name' => 'John Doe',
        'step1' => 'Processed in Step1',
        'step2' => 'Processed in Step2',
    ]);
});

it('handles an empty set of pipes', function () {
    $data = ['name' => 'John Doe'];

    $pipeline = new GenericPipeline($data, []);
    $result = $pipeline->execute();

    expect($result)->toBe($data);
});
