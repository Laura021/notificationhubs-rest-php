<?php

namespace Seis10\NotificationHubsRest\Notification\Tests;

use Seis10\NotificationHubsRest\Notification\AppleNotification;
use Seis10\NotificationHubsRest\Notification\GcmNotification;
use Seis10\NotificationHubsRest\Notification\NotificationFactory;
use Seis10\NotificationHubsRest\Notification\TemplateNotification;

class NotificationFactoryTest extends \PHPUnit_Framework_TestCase
{
    protected $factory;

    public function setUp()
    {
        $this->factory = new NotificationFactory();
        parent::setUp();
    }

    public function testCreateGcmNotification()
    {
        $notification = $this->factory->createNotification('gcm', 'Hello!');
        $this->assertTrue($notification instanceof GcmNotification);
    }

    public function testCreateAppleRegistration()
    {
        $notification = $this->factory->createNotification('apple', 'Hello!');
        $this->assertTrue($notification instanceof AppleNotification);
    }

    public function testCreateTemplateRegistration()
    {
        $notification = $this->factory->createNotification('template', ['message' => 'Hello!']);
        $this->assertTrue($notification instanceof TemplateNotification);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testCreateInvalidNotification()
    {
        $this->factory->createNotification('windows', 'Hello!');
    }
}
