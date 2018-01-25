<?php

declare(strict_types=1);

namespace Stratadox\ObservationQueue\Test\Unit;

use PHPUnit\Framework\TestCase;
use Stratadox\ObservationQueue\Test\Double\IsObservable;
use Stratadox\ObservationQueue\Test\Double\Observes;
use Stratadox\ObservationQueue\Test\Double\RegularObservable;
use Stratadox\ObservationQueue\Queue;

/**
 * @covers \Stratadox\ObservationQueue\Queue
 */
class Queue_keeps_track_of_observations extends TestCase
{
    /** @scenario */
    function triggering_the_listed_observations()
    {
        $foo = new RegularObservable('foo');
        $observer1 = $this->mockObserverThatExpects($foo);
        $observer2 = $this->mockObserverThatExpects($foo);
        $queue = new Queue;

        $queue->add($observer1, 'notify', $foo);
        $queue->add($observer2, 'notify', $foo);
        $queue->trigger();
    }

    private function mockObserverThatExpects(IsObservable $observable)
    {
        $observer = $this->createMock(Observes::class);
        $observer->expects($this->once())->method('notify')->with($observable);
        return $observer;
    }
}
