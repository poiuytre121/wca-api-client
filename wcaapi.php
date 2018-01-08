<?php

require_once __DIR__.'/competitor.php';

class WcaApi
{
    protected $apiAddress = 'https://www.worldcubeassociation.org/api/v0/';
    protected $personsSuffix = 'persons';
    protected $competitionsSuffix = 'competitions?';
    protected $curl;
    public function __construct()
    {
        $this->curl = curl_init();
        curl_setopt_array($this->curl,[
            CURLOPT_RETURNTRANSFER => 1,
        ]);
    }

    /**
     * @param $wcaId
     * @return bool|Competitor
     */
    public function getCompetitor($wcaId)
    {
        curl_setopt($this->curl,CURLOPT_URL, $this->apiAddress.$this->personsSuffix.'/'.$wcaId);
        if($response = curl_exec($this->curl)) return new Competitor(json_decode($response));
        else return false;
    }
}