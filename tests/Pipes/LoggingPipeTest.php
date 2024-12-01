<?php

use Illuminate\Support\Facades\Log;
use Skillcraft\PsychicFishstick\Pipes\LoggingPipe;

it('logs the message and passes data to the next pipe', function () {
    // Mock the Log facade
    Log::spy();

    // Mock data
    $data = collect([
        'name' => 'John Doe',
        'email' => 'john.doe@example.com',
    ]);

    // The log message
    $message = 'Processing account data';

    // Instantiate the LoggingPipe
    $pipe = new LoggingPipe($message);

    // Simulate the next step in the pipeline
    $result = $pipe->handle($data, function ($data) {
        return $data;
    });

    // Assertions
    expect($result)->toBe($data); // Ensure the data is passed to the next stage

    // Assert that the Log facade was called with the correct arguments
    Log::shouldHaveReceived('info')
        ->once()
        ->with($message, ['data' => $data]);
});
