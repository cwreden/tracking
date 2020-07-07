<?php


namespace cwreden\Tracking;


interface PersistingHandler
{
    public function persist(TrackingId $trackingId): void;
}