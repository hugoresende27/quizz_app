<?php

namespace App\QuizzClient;



class QuizzClient
{

    const API_URL = 'https://the-trivia-api.com/v2/';
    public function getRandomQuestions()
    {
        $url = 'questions';
        $response = $this->callAPI($url);
        return $response;
    }

    
    public function callAPI(string $url, string $method = 'GET')
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => QuizzClient::API_URL . $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $method,
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode( $response);
    }

}
