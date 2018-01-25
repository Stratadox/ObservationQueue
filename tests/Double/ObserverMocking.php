<?php

declare(strict_types=1);

namespace Stratadox\ObservationQueue\Test\Double;

use PHPUnit\Framework\MockObject\MockObject;

trait ObserverMocking
{
    private function mockObserver(
        array $parameters,
        $name = 'notify'
    ) : Observes
    {
        /** @var MockObject|Observes $observer */
        $observer = $this->createMock(Observes::class);
        $observer->expects($this->once())->method($name)->with(...$parameters);
        return $observer;
    }
}
