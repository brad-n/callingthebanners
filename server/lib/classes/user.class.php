<?php 

require_once('lib/classes/base.class.php');

class User extends Base {
	
	public $user_id;
	public $user_name;
	public $user_email;
	public $date_created;
	public $active;
	
	
	function __construct(&$db){
		
		$this->setDB($db);
		$this->setTable('users');
		$this->setID('user_id');
		
		$this->setFields(array('user_id', 'user_name', 'user_email', 'password', 'date_created', 'active'));
		
	}
	
	/**
	 * Sets all user member variables to the data provided
	 * 
	 * @param array $data
	 */
	private function setUserData($data){
	    
	    $this->setValue('user_id', $data['user_id']);
	    $this->setValue('user_name', $data['user_name']);
	    $this->setValue('user_email', $data['user_email']);
	    $this->setValue('date_created', $data['date_created']);
	    
	}
	
	/*
	 * Set the current session to the user user details of the object
	 */
	private function setSession(){
	    $_SESSION['user']['user_id'] = $this->user_id;
	    $_SESSION['user']['user_name'] = $this->user_name;
	    $_SESSION['user']['user_email'] = $this->user_email;
	    $_SESSION['user']['date_created'] = $this->date_created;
	}
	
	/**
	 * Sets the current user data of the object to the user session.
	 *  
	 */
	private function setFromSession(){
	    
	    $this->user_id = $_SESSION['user']['user_id'];
	    $this->user_name = $_SESSION['user']['user_name'];
	    $this->user_email = $_SESSION['user']['user_email'];
	    $this->date_created = $_SESSION['user']['date_created'];
	    
	}
	
	/**
	 * Returns an array of user data from the member variables.
	 * 
	 * @return array
	 */
	public function returnUser(){
	    
	    if($this->user_id){
        	    $user['user_id'] = $this->user_id;
        	    $user['user_name'] = $this->user_name;
        	    $user['user_email'] = $this->user_email;
        	    $user['date_created'] = $this->date_created;
	    }else{
	        $user = array();
	    }
	    
	    return $user;
	    
	}
	
	/**
	 * Checks if their is a current session/user logged in.
	 * 
	 * @return boolean
	 */
	public function isAuthed(){
	    if(!empty($this->user_id)){
	        $this->setSession();
	        return true;
	        //none on our object, do we have one in the session?
	    }elseif(!empty($_SESSION['user']['user_id'])){
	        $this->setFromSession();
	        return true;
	    }
	}
	
	/**
	 * Checks for user data in object or session and sets data to whichever is missing, returning true if there is a user, false if there is not
	 * 
	 * @param String $email
	 * @param String $password
	 * @return boolean
	 */
	public function authUser($email, $password){
	    
	    //check to see if we already have a user id.
	    if(!empty($this->user_id)){
	        $this->setSession();
	        return true;
	    //none on our object, do we have one in the session?
	    }elseif(!empty($_SESSION['user']['user_id'])){
	        $this->setFromSession();
	        return true;
	    }else{
	        //don't already have a user in the session or object, so auth against the db
	        if($this->checkUserLogin($email, $password)){
	            $this->setSession();
	            return true;
	        }else{
	            return false;
	        }
	    }
	}
	
	
	/**
	 * Checks the submitted login data and auths the user if a match is found.
	 * 
	 * @param String $email
	 * @param String $password
	 * @return boolean
	 */
	public function checkUserLogin($email, $password){
	    error_log('checking user login!');
	    $q = "SELECT * FROM users WHERE user_email = '".$this->__sanitize($email)."' AND password = '".hash('sha256', $this->__sanitize($password))."' AND active = 1";
	    error_log($q);
	    $res = $this->get($q);
        
	    if($res){
	        $this->setUserData($res);
	        $this->isAuthed();
	        return true;
	    }else{
	        return false;
	    }
	    
	}
	
	/**
	 * Gets and sets user data according to the provided field based on the member value.
	 * 
	 * @param string $field
	 * @return boolean
	 */
	public function getBy($field){
	    
	    if(!in_array($field, $this->fields)){
            return false;	        
	    }
	    
	    $res = $this->get("SELECT * FROM `".$this->getTable()."` WHERE `".$field."` = '".$this->__sanitize($this->$field));
	    $this->setData($res);
	    
	}
	
	
	/**
	 * Inserts a new user record into the database, using SHA2-256 for the password hash.
	 * 
	 * @param String $name
	 * @param String $email
	 * @param String $password
	 * @return array|boolean
	 */
	public function createUser($name, $email, $password){
	    
	    $now = date('Y-m-d H:i:s', strtotime('now'));
	    
	    $q = "INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `password`, `date_created`, `active`) VALUES (NULL, '".$this->__sanitize($name)."', '".$this->__sanitize($email)."', SHA2('".$this->__sanitize($password)."', 256), '".$now."', '1')";

	    if($this->qexec($q)){
	        
	        $user_id = mysqli_insert_id($this->db);
	        if($user_id){
	           $udetails = array('user_id' => $user_id,
                    	             'user_name' => $name,
                    	             'user_email' => $email,
                    	             'date_created' => $now);
	        
	           $this->setUserData($udetails);
        	       //isAuthed will copy over to session
	           $this->isAuthed();
	        
	        return $this->returnUser();
	        }else{
	            return false;
	        }
	        
	    }else{
	        return false;
	    }
	    
	}
	
	public function sendInviteEmail(){
	    
	    $auth_code = hash('sha256', strtotime('now').microtime(false));
	    
	    //generate and save our auth code.  We will put it in the email inviting the user to join, and use it to link their account
	    $this->auth_code = $auth_code;
	    $this->save();
	    
	    $body = "";
	    
	    $mailer = new Mailer($this->user_email, 'no-reply@callingthebanners.com <Calling The Banners>', 'You\'ve been summoned!', $body);
	    
	    
	}
	
	
}

?>