<?php

use Skillcraft\PsychicFishstick\Pipes\ValidationPipe;

it('passes validation when data meets the rules', function () {
    // Mock data
    $data = collect([
        'name' => 'John Doe',
        'email' => 'john.doe@example.com',
    ]);

    // Validation rules
    $rules = [
        'name' => 'required|string',
        'email' => 'required|email',
    ];

    // Instantiate the ValidationPipe
    $pipe = new ValidationPipe($rules);

    // Use a closure to simulate the pipeline's next method
    $result = $pipe->handle($data, function ($data) {
        return $data;
    });

    expect($result)->toBe($data);
});

it('throws an exception when data fails validation', function () {
    // Mock data
    $data = collect([
        'name' => '',
        'email' => 'invalid-email',
    ]);

    // Validation rules
    $rules = [
        'name' => 'required|string',
        'email' => 'required|email',
    ];

    // Instantiate the ValidationPipe
    $pipe = new ValidationPipe($rules);

    // Use Pest's `throws` expectation to handle exceptions
    $pipe->handle($data, function ($data) {
        return $data;
    });
})->throws(InvalidArgumentException::class, 'The name field is required.');
