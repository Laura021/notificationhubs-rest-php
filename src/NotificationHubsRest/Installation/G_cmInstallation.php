<?php

namespace Seis10\NotificationHubsRest\Installation;

class GcmInstallation extends AbstractInstallation
{
    /**
     * {@inheritdoc}
     */
    public function getRegistrationDescriptionTag()
    {
        return 'GcmInstallationDescription';
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplateRegistrationDescriptionTag()
    {
        return 'GcmTemplateInstallationDescription';
    }

    /**
     * {@inheritdoc}
     */
    public function getTokenTag()
    {
        return 'GcmInstallationId';
    }
}
