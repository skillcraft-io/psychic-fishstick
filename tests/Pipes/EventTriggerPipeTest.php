<?php
use Illuminate\Support\Facades\Event;
use Skillcraft\PsychicFishstick\Pipes\EventTriggerPipe;
it('triggers an anonymous event and passes data to the next pipe', function () {
    // Mock the Event facade
    Event::fake();

    // Mock data
    $data = collect([
        'name' => 'John Doe',
        'email' => 'john.doe@example.com',
    ]);

    // Use an anonymous event class
    $eventClass = new class($data) {
        public $data;

        public function __construct($data)
        {
            $this->data = $data;
        }
    };

    // Instantiate the EventTriggerPipe
    $pipe = new EventTriggerPipe(get_class($eventClass), []);

    // Simulate the next step in the pipeline
    $result = $pipe->handle($data, function ($data) {
        return $data;
    });

    // Assertions
    expect($result)->toBe($data); // Ensure the data is passed to the next stage

    // Assert the event was dispatched
    Event::assertDispatched(get_class($eventClass));
});
