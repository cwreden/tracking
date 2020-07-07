<?php


namespace cwreden\Tracking;


class TrackingIdFactoryUserAgentComponent implements TrackingIdFactoryComponent
{
    public function createIdPart(): string
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }
}