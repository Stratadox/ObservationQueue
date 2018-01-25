<?php

declare(strict_types=1);

namespace Stratadox\ObservationQueue\Test\Unit;

use PHPUnit\Framework\TestCase;
use Stratadox\ObservationQueue\Observation;
use Stratadox\ObservationQueue\Observations;

/**
 * @covers \Stratadox\ObservationQueue\Observations
 */
class Observations_collects_observation_objects extends TestCase
{
    /** @scenario */
    function iterating_over_the_observations()
    {
        $observations[] = $this->createMock(Observation::class);
        $observations[] = $this->createMock(Observation::class);

        $collection = new Observations(...$observations);

        self::assertNotEmpty($collection);
        foreach ($collection as $item => $observation) {
            self::assertSame($observations[$item], $observation);
        }
    }

    /** @scenario */
    function removing_an_observation()
    {
        $observation1 = $this->createMock(Observation::class);
        $observation2 = $this->createMock(Observation::class);

        $collection = new Observations($observation1, $observation2);

        $collection = $collection->remove($observation1);

        self::assertNotContains($observation1, $collection);
        self::assertContains($observation2, $collection);
    }
}
