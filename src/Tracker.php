<?php


namespace cwreden\Tracking;


class Tracker
{
    /**
     * @var PersistingHandler
     */
    private $persistingHandler;
    /**
     * @var TrackingIdFactory
     */
    private $factory;

    /**
     * Tracker constructor.
     * @param PersistingHandler $persistingHandler
     * @param TrackingIdFactory $factory
     */
    public function __construct(PersistingHandler $persistingHandler, TrackingIdFactory $factory)
    {
        $this->persistingHandler = $persistingHandler;
        $this->factory = $factory;
    }

    public function track()
    {
        $trackingId = $this->factory->create();
        $this->persistingHandler->persist($trackingId);
    }
}