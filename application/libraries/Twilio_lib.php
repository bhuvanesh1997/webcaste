<?php
require_once APPPATH . '../vendor/autoload.php';
use Twilio\Rest\Client;

class Twilio_lib {
    protected $ci;
    protected $twilio;

    public function __construct() {
        $this->ci =& get_instance();

        $sid = $this->ci->config->item('twilio_sid');
        $token = $this->ci->config->item('twilio_token');

        $this->twilio = new Client($sid, $token);
    }

    public function make_call($to, $message) {
        $from = $this->ci->config->item('twilio_number');

        try {
        	$message = $this->twilio->messages->create(
                $to,
                array(
                    "from" => $from,
                    "body" => $message
                )
            );
            return "Message sent successfully.";
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }
}