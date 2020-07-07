<?php

namespace cwreden\Tests\Tracking;

use cwreden\Tracking\Tracker;
use cwreden\Tracking\TrackingIdFactory;
use cwreden\Tracking\TrackingIdFactoryIpComponent;
use cwreden\Tracking\TrackingIdFactoryUserAgentComponent;
use cwreden\Tracking\FilePersistingHandler;
use PHPUnit\Framework\TestCase;

/**
 * Class TrackerTest
 * @covers \cwreden\Tracking\Tracker
 */
class TrackerTest extends TestCase
{
    /**
     * @var Tracker
     */
    private $tracker;
    private $persistingHandler;

    protected function setUp(): void
    {
        $tmpDir = sys_get_temp_dir();
        $this->persistingHandler = new FilePersistingHandler($tmpDir);
        $factory = new TrackingIdFactory([
            new TrackingIdFactoryIpComponent(),
            new TrackingIdFactoryUserAgentComponent()
        ]);
        $this->tracker = new Tracker($this->persistingHandler, $factory);
    }

    protected function tearDown(): void
    {
        if (file_exists($this->persistingHandler->getActiveFilePath())) {
            unlink($this->persistingHandler->getActiveFilePath());
        }
    }

    public static function assertTrackFileExists(string $activeTrackFile)
    {
        self::assertFileExists($activeTrackFile);
    }

    public static function assertTrackContains(string $uid, string $activeTrackFile)
    {
        $lines = file_get_contents($activeTrackFile);

        self::assertStringContainsString($uid, $lines);
    }

    public static function assertTrackCount(int $count, string $activeTrackFile)
    {
        self::assertCount($count, file($activeTrackFile));
    }

    public function testCanGetTrackFileForToday()
    {
        $activeFilePath = $this->persistingHandler->getActiveFilePath();

        $date = new \DateTime();
        self::assertStringEndsWith($date->format('Y_m_d') . '.track', $activeFilePath);
    }

    /**
     * @depends testCanGetTrackFileForToday
     */
    public function testCanTrackUserBasedOnUserAgent()
    {
        $userAgent = 'Unit Test Agent';
        $_SERVER['HTTP_USER_AGENT'] = $userAgent;

        $this->tracker->track();

        $activeTrackFile = $this->persistingHandler->getActiveFilePath();

        self::assertTrackFileExists($activeTrackFile);
        self::assertTrackCount(1, $activeTrackFile);
        self::assertTrackContains('21976993dd7bbbb837103159fe29990bcfcbfa14c9b1abd8c429da0e4bcf32f1', $activeTrackFile);
    }

    public function testCanTrackSameUserAgentTwice()
    {
        $userAgent = 'Unit Test Agent';
        $_SERVER['HTTP_USER_AGENT'] = $userAgent;

        $this->tracker->track();
        $this->tracker->track();

        $activeTrackFile = $this->persistingHandler->getActiveFilePath();

        self::assertTrackFileExists($activeTrackFile);
        self::assertTrackCount(2, $activeTrackFile);
        self::assertTrackContains('21976993dd7bbbb837103159fe29990bcfcbfa14c9b1abd8c429da0e4bcf32f1', $activeTrackFile);
    }

    public function testCanTrackDifferentUserAgents()
    {
        $userAgent1 = 'Unit Test Agent 1';
        $_SERVER['HTTP_USER_AGENT'] = $userAgent1;
        $this->tracker->track();

        $userAgent2 = 'Unit Test Agent 2';
        $_SERVER['HTTP_USER_AGENT'] = $userAgent2;
        $this->tracker->track();

        $activeTrackFile = $this->persistingHandler->getActiveFilePath();

        self::assertTrackFileExists($activeTrackFile);
        self::assertTrackCount(2, $activeTrackFile);
        self::assertTrackContains('06d666944bc25784b6f55a28562adea547521ef3b6e9522c045af567470d402a', $activeTrackFile);
        self::assertTrackContains('114b4813291e8b1cfe486d2748d55567eea6e1d545f0fe74efe3aeadd3b66592', $activeTrackFile);
    }
}
