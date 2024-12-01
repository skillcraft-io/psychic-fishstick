<?php

namespace Skillcraft\PsychicFishstick\Pipes;

use Closure;
use InvalidArgumentException;

class ValidationPipe
{
    protected array $rules;

    public function __construct(array $rules)
    {
        $this->rules = $rules;
    }

    public function handle($data, Closure $next)
    {
        $validator = validator($data->toArray(), $this->rules);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        return $next($data);
    }
}
