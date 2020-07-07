<?php


namespace cwreden\Tracking;


class TrackingId implements \JsonSerializable
{
    private $hash;

    /**
     * TrackingId constructor.
     * @param $hash
     */
    public function __construct(string $hash)
    {
        $this->hash = $hash;
    }

    /**
     * @return string
     */
    public function jsonSerialize()
    {
        return $this->toString();
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->hash;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toString();
    }
}