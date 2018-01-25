<?php

declare(strict_types=1);

namespace Stratadox\ObservationQueue\Test\Double;

class RegistersObservationOrder implements Observes
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

    public function observation(int $number) : IsObservable
    {
        return $this->observations[$number];
    }
}
