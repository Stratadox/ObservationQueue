<?php

declare(strict_types=1);

namespace Stratadox\ObservationQueue\Test\Double;

use function count;
use Countable;

class RegistersObservationOrder implements Observes, Countable
{
    private $observations = [];

    public function __construct(IsObservable ...$observables)
    {
        foreach ($observables as $observable) {
            $observable->subscribe($this);
        }
    }

    public function notify(IsObservable $observable) : void
    {
        $this->observations[] = $observable;
    }

    public function update(IsObservable $observable) : void
    {
        $this->notify($observable);
    }

    public function observation(int $number) : IsObservable
    {
        return $this->observations[$number];
    }

    public function count()
    {
        return count($this->observations);
    }
}
