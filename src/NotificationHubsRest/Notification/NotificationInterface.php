<?php

namespace Seis10\NotificationHubsRest\Notification;

use Seis10\NotificationHubsRest\NotificationHub\ApiContentInterface;

interface NotificationInterface extends ApiContentInterface
{
    /**
     * Returns the ServiceBusNotification-Format.
     *
     * @return string
     */
    public function getFormat();
}
