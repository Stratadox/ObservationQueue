# Observation Queue

[![Build Status](https://travis-ci.org/Stratadox/ObservationQueue.svg?branch=master)](https://travis-ci.org/Stratadox/ObservationQueue)
[![Coverage Status](https://coveralls.io/repos/github/Stratadox/ObservationQueue/badge.svg?branch=master)](https://coveralls.io/github/Stratadox/ObservationQueue?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Stratadox/ObservationQueue/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Stratadox/ObservationQueue/?branch=master)

Safeguard for observers to prevent problems in the invocation order.

## Installation

Install using composer:

`composer require stratadox/observation-queue`

## Why use this?

Use this if you have situations where observers and observables are heavily used.

Observers, by default, come with a few pretty tricky gotcha's.
Reentry, for instance, may cause bugs that can get pretty difficult to find.

### Example

Let's take a look at the following scenario:
```
We have two observables, Foo and Bar.
Observer A observes Foo, triggering Bar on update.
Observer B observes both Foo and Bar.
Foo gets triggered.
```

### What happens here?

Since `Observer A` got registered to `Foo` before `Observer B` got registered, 
`Observer A` is updated first.
Updating `Observer A` triggers `Bar`, which in turn leads to `Bar` updating its 
subscribers.

Makes sense for far, right? 
But here's the tricky part: At this point, *`Foo` has not yet updated `Observer B`!*

Of course, `Observer B` will *eventually* get updated by `Foo`. But only **after** 
receiving the update from `Bar`.

### The alternative

In situations where an Observer can trigger an update to an Observable, and the 
execution order of the relevant observers is of some importance, it may be wise
to use the ObservationQueue.

The ObservationQueue is a queue of all the messages that still need to be sent 
to the observers. Observables add their items to the queue, and proceed to 
trigger the execution of the queue.

Due to this queueing layer, observer notifications are processed in the order in
which the observables got triggered.

### What's the price?

Although the monetary price of the software is zero, using this mechanism does
introduce some shared mutable state.
In order for the queue to have any effect, multiple observables need to be given
access.

## Basic use

Normally, updating the subscribers of an Observable would go roughly like this:

```php
foreach ($this->subscribers as $subscriber) {
    $subscriber->notify($this);
}
```

When using an observation queue, instead use:

```php
foreach ($this->subscribers as $subscriber) {
    $this->queue->add($subscriber, 'notify', $this);
}
$this->queue->trigger();
```
