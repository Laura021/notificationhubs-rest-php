<?php

namespace Seis10\NotificationHubsRest\Installation;

class ApplenIstallation extends AbstractInstallation
{
    protected $expiry;

    /**
     * {@inheritdoc}
     */
    public function getRegistrationDescriptionTag()
    {
        return 'AppleInstallationDescription';
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplateRegistrationDescriptionTag()
    {
        return 'AppleTemplateInstallationDescription';
    }

    /**
     * {@inheritdoc}
     */
    public function getTokenTag()
    {
        return 'DeviceToken';
    }
}