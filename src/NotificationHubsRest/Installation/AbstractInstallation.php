<?php

namespace Seis10\NotificationHubsRest\Installation;

use Illuminate\Support\Facades\Log;

abstract class AbstractInstallation implements InstallationInterface {

    const API_VERSION = '?api-version=2015-01';

    const METHOD_GET    = 'GET';
    const METHOD_POST   = 'POST';
    const METHOD_PUT    = 'PUT';
    const METHOD_DELETE = 'DELETE';

    /**
     * @var string
     */
    protected  $token;

    /**
     * @var string
     */
    protected  $endpoint;

    /**
     * @var string
     */
    protected  $hubPath;

    /**
     * @var string
     */
    protected  $sasKeyName;

    /**
     * @var string
     */
    protected  $sasKeyValue;

    /**
     * @var array 
     */
    protected  $payload;

    /**
     * Initializes a new NotificationHub.
     *
     * @param string $connectionString
     * @param string $hubPath
     */
    public function __construct($connectionString, $hubPath)
    {
        $this->hubPath = $hubPath;
        $this->parseConnectionString($connectionString);
    }

    /* Parses the connection string.
     *
     * @param string $connectionString
     *
     * @throws \RuntimeException
     */
    public function parseConnectionString($connectionString)
    {
        $parts = explode(';', $connectionString);
        if (3 != count($parts)) {
            throw new \RuntimeException('Error parsing connection string: '.$connectionString);
        }

        foreach ($parts as $part) {
            if (0 === strpos($part, 'Endpoint')) {
                $this->endpoint = 'https'.substr($part, 11);
            } elseif (0 === strpos($part, 'SharedAccessKeyName')) {
                $this->sasKeyName = substr($part, 20);
            } elseif (0 === strpos($part, 'SharedAccessKey')) {
                $this->sasKeyValue = substr($part, 16);
            }
        }

        if (!$this->endpoint || !$this->sasKeyName || !$this->sasKeyValue) {
            throw new \RuntimeException('Invalid connection string: '.$connectionString);
        }
    }

    /**
     * Generates the SAS token.
     *
     * @param string $uri
     *
     * @return string
     */
    public  function generateSasToken($uri)
    {
        $targetUri = strtolower(rawurlencode(strtolower($uri)));
        $expires = time();
        $expiresInMins = 60;
        $expires = $expires + $expiresInMins * 60;
        $toSign = $targetUri."\n".$expires;
        $signature = rawurlencode(base64_encode(hash_hmac('sha256', $toSign, $this->sasKeyValue, true)));
        $token = 'SharedAccessSignature sr='.$targetUri.'&sig='.$signature.'&se='.$expires.'&skn='.$this->sasKeyName;

        return $token;
    }

	/**
     * {@inheritdoc}
     */
    public function buildUri($endpoint, $hubPath)
    {
        $uri = $endpoint.$hubPath.'/installations/';
        return $uri;
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
    public function getHeaders()
    {
        $headers = [
            'Content-Type: '.$this->getContentType(),
            'x-ms-version: '.'2015-01',
        ];

        return $headers;
    }


    /**
     * Returns the atom payload for the registration request.
     *
     * @throws \RuntimeException
     *
     * @return void
     */
    public function setPayload($data)
    {
        if (!$this->token) {
            throw new \RuntimeException('Token is mandatory.');
        }

        $this->payload = array();
        $this->payload['installationId'] 	= $data['installationId'];
        $this->payload['tags'] 				= $data['tag'];
        $this->payload['platform'] 			= $data['platform'];
        $this->payload['pushChannel'] 		= $data['token'];

        return json_encode($data);
    }

    /**
     * Returns the atom payload for the registration request.
     *
     * @throws \RuntimeException
     *
     * @return JSON string
     */
    public function getPayload()
    {
        if (!$this->token) {
            throw new \RuntimeException('Token is mandatory.');
        }

        return json_encode($this->payload);
    }

    /**
     * {@inheritdoc}
     */
    public function scrapeResponse($response)
    {
        /*$dom = new \DOMDocument();
        $dom->loadXML($response);

        if ($this->template) {
            $descriptionTag = $this->getTemplateRegistrationDescriptionTag();
        } else {
            $descriptionTag = $this->getRegistrationDescriptionTag();
        }

        $description = $dom->getElementsByTagName($descriptionTag)->item(0);
        if (!$description) {
            throw new \RuntimeException("Could not find '".$descriptionTag."' tag in the response: ".$response);
        }

        $result = [];
        foreach ($description->childNodes as $child) {
            if ('#text' != $child->nodeName) {
                $result[$child->nodeName] = $child->nodeValue;
            }
        }

        return $result;*/
        return true;
    }
}