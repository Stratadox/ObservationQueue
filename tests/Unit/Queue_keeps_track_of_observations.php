<?php

declare(strict_types=1);

namespace Stratadox\ObservationQueue\Test\Unit;

use PHPUnit\Framework\TestCase;
use Stratadox\ObservationQueue\Test\Double\ObserverMocking;
use Stratadox\ObservationQueue\Test\Double\RegularObservable;
use Stratadox\ObservationQueue\Queue;

/**
 * @covers \Stratadox\ObservationQueue\Queue
 */
class Queue_keeps_track_of_observations extends TestCase
{
    use ObserverMocking;

    /** @scenario */
    function triggering_the_listed_observations()
    {
        $foo = new RegularObservable('foo');
        $observer1 = $this->mockObserver([$foo]);
        $observer2 = $this->mockObserver([$foo]);
        $queue = new Queue;

        $queue->add($observer1, 'notify', $foo);
        $queue->add($observer2, 'notify', $foo);
        $queue->trigger();
    }
}
