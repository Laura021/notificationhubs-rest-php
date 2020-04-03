<?php

namespace Seis10\NotificationHubsRest\Registration;

use Seis10\NotificationHubsRest\NotificationHub\ApiContentInterface;

interface RegistrationInterface extends ApiContentInterface
{
    /**
     * Retruns the Registration ID for Notification Hub.
     *
     * @return string
     */
    public function getRegistrationId();

    /**
     * Retruns the ETag of the Registration for Notification Hub.
     *
     * @return string
     */
    public function getETag();

    /**
     * Returns the Registration Description tag name.
     *
     * @return string
     */
    public function getRegistrationDescriptionTag();

    /**
     * Returns the Registration Description tag name.
     *
     * @return string
     */
    public function getTemplateRegistrationDescriptionTag();

    /**
     * Returns the token tag name.
     *
     * @return string
     */
    public function getTokenTag();

    /**
     * Returns the token.
     *
     * @return string
     */
    public function getToken();
}
