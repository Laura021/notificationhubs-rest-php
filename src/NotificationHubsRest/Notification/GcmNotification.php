<?php

namespace Seis10\NotificationHubsRest\Notification;

/**
 *
 * @author shiroko@webware.co.jp
 *
 */
class GcmNotification extends AbstractNotification
{
    /**
     * {@inheritdoc}
     */
    public function getFormat()
    {
        return "gcm";
    }

    /**
     * {@inheritdoc}
     */
    public function getContentType()
    {
        return "application/json;charset=utf-8";
    }

    /**
     * {@inheritdoc}
     */
    public function getPayload()
    {
        try {
          $payload = [
            'data' => array_merge([
                'message' => $this->alert
            ], $this->options)
          ];

          return json_encode($payload);

        } catch(\Exception $e) {
            throw new \RuntimeException('Invalid alert.'.$e);
        }
    }
}
