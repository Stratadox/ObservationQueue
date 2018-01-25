<?php

declare(strict_types=1);

namespace Stratadox\ObservationQueue\Test\Double;

interface Observes
{
    public function notify(IsObservable $observable) : void;
}
