<?php

declare(strict_types=1);

namespace Stratadox\ObservationQueue\Test\Double;

class TriggersObservableWhenNotified implements Observes
{
    private $bar;

    public function __construct(RegularObservable $foo, RegularObservable $bar)
    {
        $foo->subscribe($this);
        $this->bar = $bar;
    }

    public function notify(IsObservable $observable) : void
    {
        $this->bar->trigger();
    }

    public function update(IsObservable $observable) : void
    {
        $this->notify($observable);
    }
}
