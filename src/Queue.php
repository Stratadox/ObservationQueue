<?php

declare(strict_types=1);

namespace Stratadox\ObservationQueue;

use SplQueue;

class Queue implements QueuesObservations
{
    private $observations;

    public function __construct()
    {
        $this->observations = new SplQueue;
    }

    public function add($observer, string $method, ...$params) : void
    {
        $this->observations->enqueue(
            new Observation($observer, $method, ...$params)
        );
    }

    public function trigger() : void
    {
        while (!$this->observations->isEmpty()) {
            $this->process($this->observations->dequeue());
        }
    }

    private function process(Observation $observation) : void
    {
        $observation->trigger();
    }
}
