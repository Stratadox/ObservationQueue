<?php

declare(strict_types=1);

namespace Stratadox\ObservationQueue\Test\Unit;

use PHPUnit\Framework\TestCase;
use Stratadox\ObservationQueue\Observation;
use Stratadox\ObservationQueue\Test\Double\ObserverMocking;
use Stratadox\ObservationQueue\Test\Double\RegularObservable;

/**
 * @covers \Stratadox\ObservationQueue\Observation
 */
class Observation_is_a_delayed_observer_update extends TestCase
{
    use ObserverMocking;

    /** @scenario */
    function triggering_an_observation()
    {
        $observable = new RegularObservable('foo');
        $observer = $this->mockObserver([$observable]);
        $observation = new Observation($observer, 'notify', $observable);

        $observation->trigger();
    }

    /** @scenario */
    function triggering_an_observation_with_a_different_method()
    {
        $observable = new RegularObservable('foo');
        $observer = $this->mockObserver([$observable], 'update');
        $observation = new Observation($observer, 'update', $observable);

        $observation->trigger();
    }
}
