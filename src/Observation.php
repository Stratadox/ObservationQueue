<?php

declare(strict_types=1);

namespace Stratadox\ObservationQueue;

class Observation
{
    private $observer;
    private $method;
    private $parameters;

    public function __construct($observer, string $method, ...$parameters)
    {
        $this->observer = $observer;
        $this->method = $method;
        $this->parameters = $parameters;
    }

    public function trigger() : void
    {
        $this->observer->{$this->method}(...$this->parameters);
    }
}
