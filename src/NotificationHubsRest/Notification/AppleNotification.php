<?php

namespace Seis10\NotificationHubsRest\Notification;


use Illuminate\Support\Facades\Log;

class AppleNotification extends AbstractNotification
{
    /**
     * @var string[]
     */
    private $supportedOptions = [
        'badge',
        'sound',
        'content-available',
    ];

    /**
     * @var string[]
     */
    private $supportedAlertProperties = [
        'title',
        'body',
        'title-loc-key',
        'title-loc-args',
        'action-loc-key',
        'loc-key',
        'loc-args',
        'launch-image',
    ];

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
        return 'application/json';
    }

    /**
     * {@inheritdoc}
     */
    public function getPayload()
    {
        $customPayloadData = null;

        if (!empty($this->options)) {

            //Log::info('!empty options');
            
            if (!empty($this->options['custom-payload-data']) && is_array($this->options['custom-payload-data'])) {
                $customPayloadData = $this->options['custom-payload-data'];
            }
            $payload = array_intersect_key($this->options, array_fill_keys($this->supportedOptions, 0));
        } else {
            $payload = [];
        }

        if ($this->alert){
        //if (is_array($this->alert)) {
            //Log::info('is_array alert');
            
            $alert = array_intersect_key($this->options, array_fill_keys($this->supportedAlertProperties, 0));
            $payload += ['alert' => $alert];
        
        } elseif (is_scalar($this->alert)) {
            $payload += ['alert' => $this->alert];
        } else {
            throw new \RuntimeException('Invalid alert.');
        }


        //og::info('payload');
        //Log::info($payload);
        $payload = ['aps' => $payload];

        if (!empty($customPayloadData)) {
            $payload += $customPayloadData;
        }

        return json_encode($payload);
    }


    /**
     * {@inheritdoc}
     */
    public function getHeaders()
    {
        if (!$this->tagsOrTagExpression) {
            $tagExpression = '';
        } elseif (is_array($this->tagsOrTagExpression)) {
            $tagExpression = implode(' || ', $this->tagsOrTagExpression);
        } else {
            $tagExpression = $this->tagsOrTagExpression;
        }

        $headers = [
            'Content-Type: '.$this->getContentType(),
            'ServiceBusNotification-Format: '.$this->getFormat(),
            'apns-push-type: alert',
            'apns-priority: 5',
        ];

        if ('' !== $tagExpression) {
            $headers[] = 'ServiceBusNotification-Tags: '.$tagExpression;
        }

        if ($this->scheduleTime instanceof \DateTime) {
            $this->scheduleTime->setTimeZone(new \DateTimeZone('UTC'));
            $headers[] = 'ServiceBusNotification-ScheduleTime: '.$this->scheduleTime->format(self::SCHEDULE_TIME_FORMAT);
        }

        return $headers;
    }

}
