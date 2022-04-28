<?php

class Reqres {

    private $lastResult;
    private $token;

    public const BASE_URL = 'https://reqres.in/api';

    public function registerUser($email, $password) {
        $data = array(
            'email' => $email,
            'password' => $password
        );
        $result = $this->post(Reqres::BASE_URL . '/register', $data);
        $this->lastResult = $result;
        if(!$result || !$result->token){
            return false;
        }
        $this->token = $result->token;
        return true;
    }

    public function loginUser($email, $password) {
        $data = array(
            'email' => $email,
            'password' => $password
        );
        $result = $this->post(Reqres::BASE_URL + '/login', $data);
        $this->lastResult = $result;
        if(!$result || !$result->token){
            return false;
        }
        $this->token = $result->token;
        return true;
    }

    public function getToken() {
        return $this->token;
    }

    public function getResources($page=0) {
        return $this->get(Reqres::BASE_URL . '/unknown?page=' . $page);
    }

    public function getResource($resourceId) {
        return $this->get(Reqres::BASE_URL . '/unknown/' . $resourceId);
    }

    private function get($url, $useToken=true) {
        $headers = array(
            'Content-Type: application/json',
            'Accept: application/json'
        );
        if($useToken){
            $headers[] = 'Authorization: Bearer ' . $this->token;
        }
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($curl);
        curl_close($curl);
        return json_decode($result);
    }

    private function post($url, $data) {
        $postString = '';
        foreach($data as $key => $value) {
            $postString .= $key . '=' . $value . '&';
        }
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postString);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        curl_close($curl);
        return json_decode($result);
    }

    public function getLastResult(){
        return $this->lastResult;
    }

}

