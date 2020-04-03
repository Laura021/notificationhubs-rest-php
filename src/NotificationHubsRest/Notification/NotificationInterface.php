<?php

namespace Seis10\NotificationHubsRest\Notification;

use Openpp\NotificationHubsRest\NotificationHub\ApiContentInterface;

interface NotificationInterface extends ApiContentInterface
{
    /**
     * Returns the ServiceBusNotification-Format.
     *
     * @return string
     */
    public function getFormat();
}
