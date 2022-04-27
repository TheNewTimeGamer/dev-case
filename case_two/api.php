<?php

class Reqres {

    private $lastResult;
    private $token;

    public const BASE_URL = 'https://reqres.in/api/';

    public function registerUser($email, $password) {
        $data = array(
            'email' => $email,
            'password' => $password
        );
        $result = $this->post($this->BASE_URL + '/register', $data);
        $this->lastResult = $result;
        var_dump($result);
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
        $result = $this->post($this->BASE_URL + '/login', $data);
        $this->lastResult = $result;
        var_dump($result);
        if(!$result || !$result->token){
            return false;
        }
        $this->token = $result->token;
        return true;
    }

    public function getToken() {
        return $this->token;
    }

    public function listUsers($page) {

    }

    public function getUser($userId) {

    }

    public function getResources($page) {

    }

    public function getResource($resourceId) {

    }

    private function get($url) {
        $content = file_get_contents($url);
        return json_decode($content);
    }

    private function post($url, $data) {
        $content = file_get_contents($url, false, stream_context_create(array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-type: application/json',
                'content' => json_encode($data)
            )
        )));
        return json_decode($content);
    }

    public function getLastResult(){
        return $this->lastResult;
    }

}

