<?php

declare(strict_types=1);

namespace Stratadox\ObservationQueue\Test\Double;

class RegularObservable implements IsObservable
{
    private $name;
    /** @var Observes[] */
    private $subscribers = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function subscribe(Observes $observer) : void
    {
        $this->subscribers[] = $observer;
    }

    public function unsubscribe(Observes $observer) : void
    {
        $this->subscribers = array_diff($this->subscribers, [$observer]);
    }

    public function trigger() : void
    {
        foreach ($this->subscribers as $subscriber) {
            $subscriber->notify($this);
        }
    }

    public function name() : string
    {
        return $this->name;
    }

    protected function subscribers() : array
    {
        return $this->subscribers;
    }
}
