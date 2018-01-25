<?php

declare(strict_types=1);

namespace Stratadox\ObservationQueue;

class Queue implements QueuesObservations
{
    private $observations;

    public function __construct()
    {
        $this->observations = new Observations;
    }

    public function add($observer, string $method, ...$params) : void
    {
        $this->observations = $this->observations->add(
            new Observation($observer, $method, ...$params)
        );
    }

    public function trigger() : void
    {
        foreach ($this->observations as $observation) {
            $this->observations = $this->observations->remove($observation);
            $observation->trigger();
        }
    }
}
