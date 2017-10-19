<?php
use Mailgun\Mailgun;

require_once '../../vendor/autoload.php';

class Mailer {
	
    public $to;
    public $from;
    public $subject;
    public $body;
    
    
    public function __construct($to, $from, $subject, $body){
        
        $this->to = $to;
        $this->from = $from;
        $this->subject = $subject;
        $this->body = $body;
        
        $this->send();
        
    }
    
    public function send(){
        
        $mg = Mailgun::create($GLOBALS['cfg']['mailgun_api']);
        $mg->messages()->send($GLOBALS['cfg']['mailgun_domain'], [
            'from'    => $this->from." <".$this->from.">",
            'to'      => $this->to,
            'subject' => $this->subject,
            'text'    => $this->body
        ]);
        
    }
	
}

?>