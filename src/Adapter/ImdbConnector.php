<?php

namespace App\Adapter;


class ImdbConnector
{

    /**
     * @var \App\Adapter\OmdbWebserviceAdapter
     */
    private $adapter;

    public function __construct(OmdbWebserviceAdapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     *
     * Retrieve imdb data using imdb movie id
     *
     * eg tt2527338: Star Wars: Episode IX - The Rise of Skywalker
     *
     * @param $id
     *
     */
    public function getMovie($id): array
    {
        $result =  $this->adapter->getMovie($id);
        return $result;

    }


}
