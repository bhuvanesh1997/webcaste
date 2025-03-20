<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        require_once FCPATH . "vendor/autoload.php";
    }

    public function login() {
        $client = new Google_Client();
        $client->setClientId($this->config->item('google_client_id'));
        $client->setClientSecret($this->config->item('google_client_secret'));
        $client->setRedirectUri(base_url($this->config->item('google_redirect_uri')));
        $client->addScope(Google_Service_Calendar::CALENDAR_READONLY);
        $client->addScope("email");
        $client->addScope("profile");
        
        $authUrl = $client->createAuthUrl();
        redirect($authUrl);
    }

    public function callback() {
        $client = new Google_Client();
        $client->setClientId($this->config->item('google_client_id'));
        $client->setClientSecret($this->config->item('google_client_secret'));
        $client->setRedirectUri(base_url($this->config->item('google_redirect_uri')));
        $client->addScope(Google_Service_Calendar::CALENDAR_READONLY);

        if ($this->input->get('code')) {
            $token = $client->fetchAccessTokenWithAuthCode($this->input->get('code'));
            $client->setAccessToken($token);

            $oauth2 = new Google_Service_Oauth2($client);
            $userInfo = $oauth2->userinfo->get();

            // Store only necessary details in session
            $this->session->set_userdata([
                'user' => [
                    'name' => $userInfo->name,
                    'email' => $userInfo->email,
                    'picture' => $userInfo->picture
                ],
                'access_token' => $token
            ]);

            redirect(base_url('dashboard'));
        } else {
            redirect(base_url());
        }
    }


    public function logout() {
        $this->session->unset_userdata('user');
        $this->session->unset_userdata('access_token');
        redirect(base_url());
    }
}