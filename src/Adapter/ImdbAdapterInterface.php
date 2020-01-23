<?php


namespace App\Adapter;


interface ImdbAdapterInterface {
    public function getMovie($id): array;
}