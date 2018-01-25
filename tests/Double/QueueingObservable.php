<?php

declare(strict_types=1);

namespace Stratadox\ObservationQueue\Test\Double;

use Stratadox\ObservationQueue\QueuesObservations;

class QueueingObservable extends RegularObservable
{
    private $queue;

    public function __construct(string $name, QueuesObservations $queue)
    {
        parent::__construct($name);
        $this->queue = $queue;
    }

    public function trigger() : void
    {
        foreach ($this->subscribers() as $subscriber) {
            $this->queue->add($subscriber, 'notify', $this);
        }
        $this->queue->trigger();
    }
}
