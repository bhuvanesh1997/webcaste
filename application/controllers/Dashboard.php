<?php
require_once FCPATH . "vendor/autoload.php";

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('Twilio_lib');
    }

    public function index() {
        if (!$this->session->userdata('access_token')) {
            redirect(base_url('Auth/login'));
        }

        $client = new Google_Client();
        $client->setAccessToken($this->session->userdata('access_token'));
        $service = new Google_Service_Calendar($client);

        $calendarId = 'primary';
        $events = $service->events->listEvents($calendarId, ['maxResults' => 5]);
        
        $data['events'] = $events->getItems();
        $this->load->view('dashboard', $data);
    }

    function cron(){
        $client = new Google_Client();
        $client->setAccessToken($this->session->userdata('access_token'));
        $service = new Google_Service_Calendar($client);
        $phone_number = $this->session->userdata('phone');
        $test = $this->twilio_lib->make_call($phone_number, 'test');
        var_dump($test);die;

        $calendarId = 'primary';
        $now = date('c');
        $minTime = date('c', strtotime('+5 minutes'));
        $events = $service->events->listEvents($calendarId, ['timeMin' => $now, 'timeMax' => $minTime]);
        if (!empty($events->getItems())) {
            foreach ($events->getItems() as $event) {
                $phone_number = $this->session->userdata('phone');
                $message = "Reminder: You have an event - " . $event->getSummary();
                $this->twilio_lib->make_call($phone_number, $message);
            }
        } else{
            echo "no event";
        }
    }
}