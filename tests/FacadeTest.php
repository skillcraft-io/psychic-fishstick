<?php

use Skillcraft\PsychicFishstick\Facades\PsychicFishstick;
use Skillcraft\PsychicFishstick\PsychicFishstickService;

test('the facade accessor for PsychicFishstick should return PsychicFishstickService class', function () {
    $expectedFacadeAccessor = PsychicFishstickService::class;
    expect(PsychicFishstick::getFacadeRoot())->toBeInstanceOf($expectedFacadeAccessor);
});


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

    $result = PsychicFishstick::process($data, $pipes);

    expect($result)->toMatchArray([
        'name' => 'John Doe',
        'step1' => 'Processed in Step1',
        'step2' => 'Processed in Step2',
    ]);
});

it('handles an empty set of pipes', function () {
    $data = ['name' => 'John Doe'];

    $result = PsychicFishstick::process($data, []);

    expect($result)->toBe($data);
});
