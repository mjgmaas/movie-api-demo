<?php

namespace App\Adapter;

use GuzzleHttp\Client as GuzzleHttpClient;
use http\Exception\RuntimeException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;


abstract class AbstractWebserviceAdapter
{
    private $httpClient;
    private $endpoint = null;


    /**
    * @return \GuzzleHttp\Client
    */
    public function getHttpClient(): GuzzleHttpClient
    {
        if($this->httpClient) {
            return $this->httpClient;
        }

        $this->httpClient = new GuzzleHttpClient([
            'verify' => true
        ]);

        return $this->httpClient;
    }

    /**
     * @return mixed
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * @param mixed $endpoint
     */
    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
    }

    /**
     * Construct a url to a REST resource
     *
     * @param $resourceUri
     * @return string
     */
    public function constuctUri($resourceUrl){
        return $this->getEndpoint() . $resourceUrl;
    }

    /**
     * Execute a request and do error handling
     *
     * @param string $method
     * @param string $url
     * @param array $options
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function request(string $method, string $url, array $options = [])
    {
        try{
            $result = $this->getHttpClient()->request($method, $this->constuctUri($url), $options);
        }
        catch(\GuzzleHttp\Exception\ClientException $e){
        }
        catch(\GuzzleHttp\Exception\RequestException $e){
        }

        if($result->getStatusCode() === 200){
            return $result;
        }
        else{
            throw new RuntimeException("Unexpected statuscode received from webservice request:  " . $this->constuctUri($url), $result->getStatusCode());

        }

    }

}
