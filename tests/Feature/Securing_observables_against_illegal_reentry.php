<?php

declare(strict_types=1);

namespace Stratadox\ObservationQueue\Test\Feature;

use PHPUnit\Framework\TestCase;
use Stratadox\ObservationQueue\Test\Double\QueueingObservable;
use Stratadox\ObservationQueue\Test\Double\RegistersObservationOrder;
use Stratadox\ObservationQueue\Test\Double\RegularObservable;
use Stratadox\ObservationQueue\Test\Double\TriggersObservableWhenNotified;
use Stratadox\ObservationQueue\Queue;

/**
 * @coversNothing
 */
class Securing_observables_against_illegal_reentry extends TestCase
{
    /** @scenario */
    function asserting_regular_observers_get_it_wrong()
    {
        $foo = new RegularObservable('FOO');
        $bar = new RegularObservable('BAR');
        new TriggersObservableWhenNotified($foo, $bar);
        $observer = new RegistersObservationOrder($foo, $bar);

        $foo->trigger();

        self::assertSame($bar, $observer->observation(0));
        self::assertSame($foo, $observer->observation(1));
        self::assertCount(2, $observer);
    }

    /** @scenario */
    function ensuring_the_correct_invocation_order()
    {
        $queue = new Queue;
        $foo = new QueueingObservable('FOO', $queue);
        $bar = new QueueingObservable('BAR', $queue);
        new TriggersObservableWhenNotified($foo, $bar);
        $observer = new RegistersObservationOrder($foo, $bar);

        $foo->trigger();

        self::assertSame($foo, $observer->observation(0));
        self::assertSame($bar, $observer->observation(1));
        self::assertCount(2, $observer);
    }
}
