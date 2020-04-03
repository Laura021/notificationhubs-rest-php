<?php

namespace Seis10\NotificationHubsRest\Registration\Tests;

use Seis10\NotificationHubsRest\Registration\AppleRegistration;
use Seis10\NotificationHubsRest\Registration\GcmRegistration;
use Seis10\NotificationHubsRest\Registration\RegistrationFactory;
use Seis10\NotificationHubsRest\Registration\WindowsRegistration;

class RegistrationFactoryTest extends \PHPUnit_Framework_TestCase
{
    protected $factory;

    public function setUp()
    {
        $this->factory = new RegistrationFactory();
        parent::setUp();
    }

    public function testCreateGcmRegistration()
    {
        $registration = $this->factory->createRegistration('gcm');
        $this->assertTrue($registration instanceof GcmRegistration);
    }

    public function testCreateAppleRegistration()
    {
        $registration = $this->factory->createRegistration('apple');
        $this->assertTrue($registration instanceof AppleRegistration);
    }

    public function testCreateWindowsRegistration()
    {
        $registration = $this->factory->createRegistration('windows');
        $this->assertTrue($registration instanceof WindowsRegistration);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testCreateInvalidRegistration()
    {
        $this->factory->createRegistration('baidu');
    }
}
