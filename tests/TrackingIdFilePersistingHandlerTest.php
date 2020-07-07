<?php

namespace cwreden\Tests\Tracking;

use cwreden\Tracking\TrackingId;
use cwreden\Tracking\FilePersistingHandler;
use PHPUnit\Framework\TestCase;

/**
 * Class TrackingIdFilePersistingHandlerTest
 * @covers \cwreden\Tracking\FilePersistingHandler
 */
class TrackingIdFilePersistingHandlerTest extends TestCase
{
    private $persistingHandler;

    protected function setUp(): void
    {
        $tmpDir = sys_get_temp_dir();
        $this->persistingHandler = new FilePersistingHandler($tmpDir);
    }

    public function testCanPersistSingleTrackingId()
    {
        $this->persistingHandler->persist(new TrackingId('testHash'));
    }

    public function testCanGetActiveTrackingFile()
    {
        $filePath = $this->persistingHandler->getActiveFilePath();

        self::assertIsString($filePath);
        self::assertStringEndsWith($filePath, '.track');
        $date = new \DateTime();
        self::assertStringEndsWith($date->format('Y_m_d') . '.track', $filePath);
    }
}
