# Laravel Pipeline Package

A reusable and extensible pipeline package for Laravel applications.
This package provides a base pipeline class to process data through a series of customizable steps (pipes).
It adheres to Laravel's `Illuminate\Pipeline` component, making it ideal for workflows that require sequential
processing.

---

## Features

- **BasePipeline**: Abstract class to define structured pipelines.
- **Reusable Pipes**: Create reusable steps for common processing logic.
- **Extensible**: Customize pipelines for various workflows.
- **Tested**: Fully unit-tested with 100% code coverage.

---

## Installation

Install the package via Composer:

```bash
composer require your-vendor/pipeline
```

## Defining a Pipeline

Extend the ```BasePipeline``` class to create your pipeline:

```php
use Skillcraft\PsychicFishstick\Abstracts\BasePipeline;

class ExamplePipeline extends BasePipeline
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
            \App\Pipes\StepOne::class,
            \App\Pipes\StepTwo::class,
        ];
    }
}
```

## GenericPipeline

The GenericPipeline class is a flexible option for creating pipelines without defining a dedicated class.
It is ideal for simple workflows.

```php
use Skillcraft\PsychicFishstick\Pipelines\GenericPipeline;

// Mock data
$data = ['name' => 'Jane Doe'];

// Define pipes
$pipes = [
    \App\Pipes\StepOne::class,
    \App\Pipes\StepTwo::class,
];

// Instantiate and execute the pipeline
$pipeline = new GenericPipeline($data, $pipes);
$result = $pipeline->execute();

print_r($result);

/*
Output:
[
    'name' => 'Jane Doe',
    'step_one' => 'Processed by StepOne',
    'step_two' => 'Processed by StepTwo',
]
*/
```

## When to Use `GenericPipeline` vs. `BasePipeline`

| Use Case           | `GenericPipeline`                           | `BasePipeline`                               |
|--------------------|---------------------------------------------|----------------------------------------------|
| Simple workflows   | Ideal for one-off or straightforward cases. | Overhead of defining a class is unnecessary. |
| Reusable workflows | Can work but lacks structured organization. | Better suited for well-defined pipelines.    |
| Extensibility      | Less extensible without adding complexity.  | Encourages a structured, extensible design.  |
| Type safety        | Not enforced for pipes or data.             | Ensures strict contracts and uniformity.     |

## Creating Pipes

A pipe is a step in the pipeline. Each pipe processes the data and passes it to the next step.

```php
namespace App\Pipes;

use Closure;

class StepOne
{
    public function handle($data, Closure $next)
    {
        $data['step_one'] = 'Processed by StepOne';

        return $next($data);
    }
}
```

Another example:

```php
namespace App\Pipes;

use Closure;

class StepTwo
{
    public function handle($data, Closure $next)
    {
        $data['step_two'] = 'Processed by StepTwo';

        return $next($data);
    }
}
```

## Executing the Pipeline

Use your pipeline to process data:

```php
$data = ['name' => 'John Doe'];

$pipeline = new ExamplePipeline($data);
$result = $pipeline->execute();

print_r($result);

/*
Output:
[
    'name' => 'John Doe',
    'step_one' => 'Processed by StepOne',
    'step_two' => 'Processed by StepTwo',
]
*/
```

## Example: LoggingPipe

A reusable pipe for logging messages.

```php
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
```

## Using LoggingPipe in a Pipeline

```php
use Skillcraft\PsychicFishstick\Abstracts\BasePipeline;
use Skillcraft\PsychicFishstick\Pipes\LoggingPipe;

class YourLoggingPipeline extends BasePipeline
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
            new LoggingPipe('Processing data in the pipeline'),
        ];
    }
}

$data = ['key' => 'value'];
$pipeline = new LoggingPipeline($data);
$result = $pipeline->execute();
```

## Example: EventTriggerPipe

A reusable pipe for dispatching events.

```php
namespace Skillcraft\PsychicFishstick\Pipes;

use Closure;

class EventTriggerPipe
{
    protected string $eventClass;
    protected array $eventData;

    public function __construct(string $eventClass, array $eventData = [])
    {
        $this->eventClass = $eventClass;
        $this->eventData = $eventData;
    }

    public function handle($data, Closure $next)
    {
        event(new $this->eventClass($data, ...$this->eventData));

        return $next($data);
    }
}
```

## Using EventTriggerPipe in a Pipeline

```php
use Skillcraft\PsychicFishstick\Abstracts\BasePipeline;
use Skillcraft\PsychicFishstick\Pipes\EventTriggerPipe;

class EventPipeline extends BasePipeline
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
            new EventTriggerPipe(\App\Events\DataProcessed::class, ['extra' => 'value']),
        ];
    }
}

$data = ['key' => 'value'];
$pipeline = new EventPipeline($data);
$result = $pipeline->execute();
```

## Development

## DDEV Setup

This package includes **DDEV** for local environment management, ensuring an easy-to-use, consistent development
environment.

### **Prerequisites**

- Install [DDEV](https://ddev.readthedocs.io/en/stable/).

### **Setup Steps**

1. Clone the repository:
   ```bash
   git clone https://github.com/skillcraft-io/psychic-fishstick.git
   cd psychic-fishstick
   ```

2. Start the DDEV environment:
   ```bash
   ddev start
   ```

3. Install dependencies using Composer:
   ```bash
   ddev composer install
   ```

4. Run tests to verify the setup:
   ```bash
   ddev exec ./vendor/bin/pest
   ```

5. Access your project:
    - Web: Nothing (This is just a package and has no views or even routes).
    - CLI: Use `ddev exec` for running commands in the container.

---

## Testing

```bash
./vendor/bin/pest
```

## Contributing

Contributions are welcome! Please follow these steps:

- Fork the repository.
- Create a new branch for your feature or bugfix.
- Write tests for your changes.
- Submit a pull request.

## License

This package is open-sourced software licensed under the MIT license.
