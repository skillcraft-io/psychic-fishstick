<?php

namespace Skillcraft\PsychicFishstick\Facades;

use Illuminate\Support\Facades\Facade;
use Skillcraft\PsychicFishstick\PsychicFishstickService;

/**
 * @method static mixed process(mixed $data, array $pipes)
 *
 * @see PsychicFishstickService
 */
class PsychicFishstick extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return PsychicFishstickService::class;
    }
}
