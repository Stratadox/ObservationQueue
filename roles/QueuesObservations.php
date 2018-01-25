<?php

declare(strict_types=1);

namespace Stratadox\ObservationQueue;

interface QueuesObservations
{
    public function add($observer, string $method, ...$params) : void;
    public function trigger() : void;
}
