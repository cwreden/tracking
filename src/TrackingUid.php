<?php


namespace cwreden\Tracking;


class TrackingUid
{
    /**
     * @var string
     */
    private $userAgent;

    public function __toString()
    {
        return $this->toString();
    }

    public function toString()
    {
        return sha1($this->userAgent);
    }

}