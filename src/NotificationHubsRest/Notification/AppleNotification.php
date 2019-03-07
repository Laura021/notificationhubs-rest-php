<?php

namespace Openpp\NotificationHubsRest\Notification;

class AppleNotification extends AbstractNotification
{
    /**
     * {@inheritdoc}
     */
    public function getFormat()
    {
        return 'apple';
    }

    /**
     * {@inheritdoc}
     */
    public function getContentType()
    {
        return 'application/json;charset=utf-8';
    }

    /**
     * {@inheritdoc}
     */
    public function getPayload()
    {
        try {
            $payload = [
                'aps' => array_merge([
                    'alert' => $this->alert
                ], $this->options)
            ];

            return json_encode($payload);

        } catch(\Exception $e) {
            throw new \RuntimeException('Invalid alert.'.$e);
        }
    }
}
