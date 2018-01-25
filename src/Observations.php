<?php

declare(strict_types=1);

namespace Stratadox\ObservationQueue;

use Stratadox\Collection\Appendable;
use Stratadox\Collection\Purgeable;
use Stratadox\ImmutableCollection\Appending;
use Stratadox\ImmutableCollection\ImmutableCollection;
use Stratadox\ImmutableCollection\Purging;

class Observations extends ImmutableCollection implements Appendable, Purgeable
{
    use Appending, Purging;

    public function __construct(Observation ...$observations)
    {
        parent::__construct(...$observations);
    }

    public function current() : Observation
    {
        return parent::current();
    }
}
