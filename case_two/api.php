<?php

class Reqres {

    private $lastResult;    // Used for whenever an api function returns false, this will allow you to debug the issue through 'getLastResult()'.
    private $token;         // Could also be stored in local storage or a a cookie.

    public const BASE_URL = 'https://reqres.in/api';

    /**
     * @param string $email Email of the user.
     * @param string $password Password of the user.
     * @return bool True if user registration is successful, false otherwise.
     */
    public function registerUser($email, $password) {
        $data = array(
            'email' => $email,
            'password' => $password
        );
        $result = $this->post(Reqres::BASE_URL . '/register', $data);
        if(!$result || !$result->token){
            return false;
        }
        $this->token = $result->token;
        return true;
    }

    /**
     * @param string $email Email of the user.
     * @param string $password Password of the user.
     * @return bool True if user login is successful, false otherwise.
     */
    public function loginUser($email, $password) {
        $data = array(
            'email' => $email,
            'password' => $password
        );
        $result = $this->post(Reqres::BASE_URL . '/login', $data);
        if(!$result || !$result->token){
            return false;
        }
        $this->token = $result->token;
        return true;
    }

    /**
     * Deletes stored auth-token.
     */
    public function logoutUser() { 
        $this->token = null;
    }

    /**
     * @return string auth-token.
     */
    public function getToken() {
        return $this->token;
    }

    /**
     * @param int $page Page number (default 0).
     * @return object Object/Table containing resources from the given page.
     */
    public function getResources($page=0) {
        return $this->get(Reqres::BASE_URL . '/unknown?page=' . $page);
    }

    /**
     * @param int $resourceId Id of the specific resource to return.
     * @return object Object/Table containing resource.
     */
    public function getResource($resourceId) {
        return $this->get(Reqres::BASE_URL . '/unknown/' . $resourceId);
    }

    /**
     * @param bool $useToken Whether to use the token or not.
     * @return array Resulting headers.
     */
    private function buildHeaders($useToken) {
        // Developer note: Content-Type should be supplied but is not strictly required for this api.
        $headers = array(
            'Accept: application/json'
        );
        if($useToken && $this->token){
            $headers[] = 'Authorization: Bearer ' . $this->token;
        }
        return $headers;
    }

    /**
     * Perform a get request to the given url, by default uses auth-token.
     * @param string $url The url.
     * @param bool $useToken Whether to use the token or not.
     * @return object
     */
    private function get($url, $useToken=true) {
        $headers = $this->buildHeaders($useToken);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($curl);
        $this->lastResult = $result;
        curl_close($curl);
        return json_decode($result);
    }

    /**
     * Perform a post request to the given url, by default uses auth-token.
     * @param string $url The url.
     * @param bool $useToken Whether to use the token or not.
     * @return object Decoded json result.
     */
    private function post($url, $data, $useToken=true) {
        $headers = $this->buildHeaders($useToken);
        $postString = '';
        foreach($data as $key => $value) {
            $postString .= $key . '=' . $value . '&';
        }
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postString);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($curl);
        $this->lastResult = $result;
        curl_close($curl);
        return json_decode($result);
    }

    /**
     * Returns the last raw result from the api. Handy for debugging.
     * @return mixed
     */
    public function getLastResult(){
        return $this->lastResult;
    }

}

