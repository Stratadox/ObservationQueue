<?php

declare(strict_types=1);

namespace Stratadox\ObservationQueue\Test\Double;

interface IsObservable
{
    public function subscribe(Observes $observer) : void;
    public function unsubscribe(Observes $observer) : void;
    public function trigger() : void;
    public function name() : string;
}
