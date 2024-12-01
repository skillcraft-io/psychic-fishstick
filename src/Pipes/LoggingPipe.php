<?php

namespace Skillcraft\PsychicFishstick\Pipes;

use Closure;
use Illuminate\Support\Facades\Log;

class LoggingPipe
{
    protected string $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function handle($data, Closure $next)
    {
        Log::info($this->message, ['data' => $data]);

        return $next($data);
    }
}
