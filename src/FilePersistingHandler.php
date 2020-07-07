<?php


namespace cwreden\Tracking;


class FilePersistingHandler implements PersistingHandler
{
    /**
     * @var string
     */
    private $trackingDirectory;

    /**
     * FilePersistingHandler constructor.
     * @param string $trackingDirectory
     */
    public function __construct(string $trackingDirectory)
    {
        $this->trackingDirectory = $trackingDirectory;
    }

    /**
     * @param TrackingId $trackingId
     */
    public function persist(TrackingId $trackingId): void
    {
        try {
            file_put_contents($this->getActiveFilePath(), (string)$trackingId . PHP_EOL, FILE_APPEND);
        } catch (\Exception $exception) {
            // TODO log
        }
    }

    /**
     * @return string
     */
    public function getActiveFilePath(): string
    {
        $dateTime = new \DateTime();

        return $this->trackingDirectory . DIRECTORY_SEPARATOR . $dateTime->format('Y_m_d') . '.track';
    }
}