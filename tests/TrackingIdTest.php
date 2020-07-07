<?php

namespace cwreden\Tests\Tracking;

use cwreden\Tracking\TrackingId;
use PHPUnit\Framework\TestCase;

/**
 * Class TrackingIdTest
 * @covers \cwreden\Tracking\TrackingId
 */
class TrackingIdTest extends TestCase
{
    public function testCanConvertToString()
    {
        $hash = hash('sha256', 'testValue');
        $trackingId = new TrackingId($hash);

        self::assertSame($hash, $trackingId->toString());
        self::assertSame($hash, $trackingId->__toString());
        self::assertSame($hash, (string)$trackingId);
    }

    public function testCanConvertedToJson()
    {
        $hash = hash('sha256', 'testValue');
        $trackingId = new TrackingId($hash);

        self::assertSame(json_encode($hash), json_encode($trackingId));
    }
}
