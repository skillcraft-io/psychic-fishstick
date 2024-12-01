<?php

namespace Skillcraft\PsychicFishstick\Pipes;

use Closure;

class EventTriggerPipe
{
    /**
     * The event class to be triggered.
     */
    protected string $eventClass;

    /**
     * Data to pass to the event.
     */
    protected array $eventData;

    /**
     * Constructor to initialize the pipe with the event class and data.
     *
     * @param string $eventClass The event class to trigger.
     * @param array $eventData Data to pass to the event.
     */
    public function __construct(string $eventClass, array $eventData = [])
    {
        $this->eventClass = $eventClass;
        $this->eventData = $eventData;
    }

    /**
     * Handle the pipeline step.
     *
     * @param mixed $data
     * @param Closure $next
     * @return mixed
     */
    public function handle(mixed $data, Closure $next): mixed
    {
        // Trigger the event with the provided data
        event(new $this->eventClass($data, ...$this->eventData));

        return $next($data);
    }
}
