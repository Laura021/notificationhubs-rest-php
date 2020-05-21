<?php

namespace Seis10\NotificationHubsRest\Installation;

use Seis10\NotificationHubsRest\Notification\InstallationInterface;

use Illuminate\Support\Facades\Log;

class AppleInstallation extends AbstractInstallation
{
    protected $expiry;

  
    public function __construct($connectionString, $hubPath) {
        Log::info('Seis10\NotificationHubsRest\Installation\AppleInstallation::__construct');
        parent::__construct($connectionString, $hubPath);        
    }

    
    /**
     * Create Installation
     *
     * @param array $data
     *
     * @throws \RuntimeException
     *
     * @return mixed
     */
    public function createNewInstallation($data)
    {
        Log::info('Seis10\NotificationHubsRest\Installation\AppleInstallation::createInstallation');

        $uri = $this->buildUri($this->endpoint, $this->hubPath).$data['installationId'].self::API_VERSION;
        
        /*Log::info("uri");
        Log::info($uri);*/
        
        $this->token = $this->generateSasToken($uri);
       
        /*Log::info("token"); 
        Log::info($this->token);*/

        $this->setPayload($data);
        
        $headers = array_merge(['Authorization: '.$this->token], $this->getHeaders());

        Log::info("payload"); 
        Log::info($this->getPayload());

        $response = $this->request(self::METHOD_PUT, $uri, $headers, $this->getPayload());
        
        /*Log::info('response');
        Log::info($response);*/
        
        return true;
    }

    /**
     * Send the request to API.
     *
     * @param string $method
     * @param string $uri
     * @param array  $headers
     * @param string $payload
     * @param bool   $responseHeader
     *
     * @throws \RuntimeException
     *
     * @return string
     *
     * @codeCoverageIgnore
     */
    protected function request($method, $uri, $headers, $payload = null, $responseHeader = false)
    {
        $ch = curl_init($uri);

        $options = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HEADER => $responseHeader,
            CURLOPT_HTTPHEADER => $headers,
        ];

        $options[CURLOPT_CUSTOMREQUEST] = $method;

        if (!is_null($payload)) {
            $options[CURLOPT_POSTFIELDS] = $payload;
        }

        curl_setopt_array($ch, $options);

        $response = curl_exec($ch);

        if (false === $response) {
            throw new \RuntimeException(curl_error($ch));
        }

        $info = curl_getinfo($ch);
        if (200 != $info['http_code'] && 201 != $info['http_code']) {
            throw new \RuntimeException('Error sending request: '.$info['http_code'].' msg: '.$response);
        }

        return $response;
    }
}