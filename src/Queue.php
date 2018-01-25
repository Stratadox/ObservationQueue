<?php

declare(strict_types=1);

namespace Stratadox\ObservationQueue;

class Queue implements QueuesObservations
{
    private $observations;

    public function add($observer, string $method, ...$params) : void
    {
        $this->observations[] = [$observer, $method, $params];
    }

    public function trigger() : void
    {
        foreach ($this->observations as $i => $observation) {
            unset($this->observations[$i]);
            call_user_func(
                [$observation[0], $observation[1]],
                ...$observation[2]
            );
        }
    }
}
