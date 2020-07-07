<?php


namespace cwreden\Tracking;


class TrackingIdFactoryIpComponent implements TrackingIdFactoryComponent
{
    public function createIdPart(): string
    {
        return (string)$_SERVER['REMOTE_ADDR'];
    }
}