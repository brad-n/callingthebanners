<?php 

require_once('lib/classes/base.class.php');

class GroupUser extends Base {
	
	public $link_id;
	public $group_id;
	public $user_id;
	public $date_created;
	public $active;
	
	
	function __construct(&$db){
		
		$this->setDB($db);
		$this->setTable('group_users');
		$this->setID('link_id');
		
		$this->setFields(array('link_id', 'group_id', 'user_id', 'role', 'date_created', 'active'));
		
	}
	
	private function onAfterInsert(){
        
	    //after we have added a new user we need to increment our group count
	    $G = new Group($this->db);
	    $G->incrementMemberCount($this->group_id);
	    
	}
	
	/**
	 * Sets all user member variables to the data provided
	 * 
	 * @param array $data
	 */
	private function setUserData($data){

	    $this->setValue('link_id', $data['user_name']);
	    $this->setValue('group_id', $data['group_id']);
	    $this->setValue('user_id', $data['user_id']);
	    $this->setValue('role', $data['role']);
	    $this->setValue('date_created', $data['date_created']);
	    $this->setValue('active', $data['active']);
	    
	}
	
	/**
	 * Returns an array of user data from the member variables.
	 * 
	 * @return array
	 */
	public function returnGroupUser(){
	    
	    $link = array();
	    
	    if($this->user_id){
	        $link['link_id'] = $this->link_id;
        	    $link['group_id'] = $this->group_id;
        	    $link['user_id'] = $this->user_id;
        	    $link['role'] = $this->role;
        	    $link['date_created'] = $this->date_created;
        	    $link['active'] = $this->active;
	    }
	    
	    return $link;
	    
	}
	
    /**
     * Add the user identified by the member user_id to the group identified by the member group_id
     * 
     * @return boolean
     */
    public function addUserToGroup(){
        
        $this->setValue('active', 1);
        $this->setValue('date_created', $this->getNow());
        
        $this->save();
        
        if(empty($this->link_id) && !$this->link_id){
            return false;
        }
        
        return false;
        
    }
    
    public function inviteUserToGroup($user_email, $group_id){
        
        $U = new User($this->db);
        if(!$U->isAuthed()){
            return false;
        }
        
        //first, we want to check to see if this user is already in our system.
        $Invited = new User($this->db);
        $Invited->setValue('user_email', $user_email);
        $Invited->getBy('user_email');
        
        if(!$Invited->user_id){
            //we don't have a user, so lets create it.
            $Invited->save();
            
            //send an invite email to the user
            $Invited->sendInviteEmail();
            
        }
        
        
    }
	
}

?>