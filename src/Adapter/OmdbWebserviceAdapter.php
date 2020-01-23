<?php

namespace App\Adapter;

use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class OmdbWebserviceAdapter extends AbstractWebserviceAdapter implements ImdbAdapterInterface
{
    private $options = [];

    public function __construct(ContainerBagInterface $params)
    {
        $this->setEndpoint("http://omdbapi.com");
        $this->setHeaders();
        $this->addQueryParam('apikey', $params->get('app.omdb.api.key'));

    }

    /**
     *
     * Request imdb data using omdb.com webservice
     *
     * @param string $options
     * @return array
     */
    public function getMovie($id): array
    {

        $this->addQueryParam('i', $id);

        $requestResult = $this->request("GET", "/", $this->options);

        $result = \GuzzleHttp\json_decode($requestResult->getBody(), true);
        if($result['Response'] === 'True'){
            return $result;
        }
        else {
            throw new NotFoundHttpException();
        }

    }

    private function setHeaders(){

        $this->options = array_merge($this->options, ['headers' => [
            'Accept'     => 'application/json',
            ]
        ]);
    }

    private function addQueryParam($key, $value) {
        $this->options['query'][$key] = $value;
    }



}
