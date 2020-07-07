<?php


namespace cwreden\Tracking;


class TrackingIdFactory
{
    const ALGO_SHA_256 = 'sha256';
    /**
     * @var TrackingIdFactoryComponent[]
     */
    private $components = [];
    /**
     * @var string
     */
    private $algorithm;

    /**
     * TrackingIdFactory constructor.
     * @param array $components
     * @param string $algo
     */
    public function __construct(array $components, $algo = self::ALGO_SHA_256)
    {
        $this->components = $components;
        $this->algorithm = $algo;
    }

    /**
     * @return TrackingId
     */
    public function create(): TrackingId
    {
        $idParts = '';
        foreach ($this->components as $component) {
            $idParts .= $component->createIdPart();
        }

        return new TrackingId(hash($this->algorithm, $idParts));
    }
}