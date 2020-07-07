<?php


namespace cwreden\Tracking;


interface TrackingIdFactoryComponent
{
    public function createIdPart(): string;
}