<?php

class ApiController extends Zend_Controller_Action
{
    protected $_response;

    public function init()
    {
        $requestoption = array(
            'auth' => array(
                'url' => 'auth/token/from_oauth1',
                'data' => '{ "oauth1_token": "qievr8hamyg6ndck", "oauth1_token_secret": "qomoftv0472git7" }',
            ),
            'curacc' => array(
                'url' => 'users/get_current_account',
                'data' => '',
            ),
        );

        /*
                curl -X POST https://api.dropboxapi.com/2/auth/token/from_oauth1 \
            --header "Authorization: Basic cGpjMDEwaG80NmNzM3NpOnp5dGVwZTE0YmphYXY0Mg==" \
            --header "Content-Type: application/json" \
            --data "{\"oauth1_token\": \"qievr8hamyg6ndck\",\"oauth1_token_secret\": \"qomoftv0472git7\"}"
            */

        /*

        $config = array(
            'adapter' => 'Zend_Http_Client_Adapter_Curl',);
        $url = "https://api.dropboxapi.com/2/" . $requestoption['curacc']['url'];
        $client = new Zend_Http_Client($url, $config);
        $client->setHeaders("Authorization: Bearer zE7rjRBZxoMAAAAAAAAUgZVocc9DLkGgm_om6JaAwEZVtvN3JBXTOYpkwjy-kHsq");
        $client->setHeaders("Content-Type: application/json");
       */


        //$client->setRawData($authdata);

        //$response = $client->request("POST");
        /*

                $client = new Zend_Http_Client();
                $client->setUri("https://api.dropboxapi.com/2/" . $requestoption['curacc']['url']);
                //$client->setHeaders("Authorization", "Basic cGpjMDEwaG80NmNzM3NpOnp5dGVwZTE0YmphYXY0Mg");
                $client->setHeaders("Content-Type", "application/json");
                $client->setHeaders('Authorization', 'Bearer zE7rjRBZxoMAAAAAAAAUgrAP-iafGMkoz3iNMMzLqfT36s0badbxPceQeZHHzc91');
                //$client->setHeaders('Content-Type', 'text/html; charset=utf-8');

                //$client->setRawData($requestoption['auth']['data']);

                $response = $client->request('POST');*/



        $this->_response = $response;

    }

    public function indexAction()
    {
        $a = $this->_response;
        $b = $this->_response->getRawBody();
        $this->view->errormessage = ($this->_response->getRawBody());
    }


}

