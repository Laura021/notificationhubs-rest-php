<?php

namespace Seis10\NotificationHubsRest\Registration;

use Illuminate\Support\Facades\Log;

class AppleRegistration extends AbstractRegistration
{
    protected $expiry;

    /**
     * {@inheritdoc}
     */
    public function getRegistrationDescriptionTag()
    {
        return 'AppleRegistrationDescription';
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplateRegistrationDescriptionTag()
    {
        return 'AppleTemplateRegistrationDescription';
    }

    /**
     * {@inheritdoc}
     */
    public function getTokenTag()
    {
        return 'DeviceToken';
    }

    /**
     * Sets the expiry for the template.
     *
     * @param string $expiry
     *
     * @return AppleRegistration this object
     */
    public function setExpiry($expiry)
    {
        $this->expiry = $expiry;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function appendAdditionalNode($descriptionNode)
    {
        if ($this->template && $this->expiry) {
            $descriptionNode->appendChild($this->dom->createElement('Expiry', $this->expiry));
        }
    }

        /**
     * Returns the atom payload for the registration request.
     *
     * @throws \RuntimeException
     *
     * @return string
     */
    public function getPayload()
    {
        //Log::info('Apple GetPayload');
        
        if (!$this->token) {
            throw new \RuntimeException('Token is mandatory.');
        }

        $descriptionNode = $this->appendDescriptionNode();

        //Log::info('descriptionNode type: '.gettype($descriptionNode));


        $this->appendTagNode($descriptionNode);
        $this->appendTokenNode($descriptionNode);
        $this->appendTemplateNode($descriptionNode);
        $this->appendAdditionalNode($descriptionNode);

        //og::info(json_encode($descriptionNode));

        $this->dom->formatOutput = true;


    }

      
}
