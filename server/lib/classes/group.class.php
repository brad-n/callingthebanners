<?php 

require_once('lib/classes/base.class.php');

class Group extends Base {
	
	public $group_id;
	public $group_name;
	public $date_created;
	public $member_count;
	public $active;
	
	
	function __construct(&$db){
		
		$this->setDB($db);
		$this->setTable('groups');
		$this->setID('group_id');
		
		$this->setFields(array('group_id', 'group_name', 'created_by', 'date_created', 'member_count', 'active'));
		
	}
	
	public function onAfterInsert(){
	    
	    //after we have created the group, we need to add our user to it
	    $UG = new GroupUser($this->db);
	    $U = new User($this->db);

	    if($U->isAuthed()){
	        $UG->setValue('group_id', $this->group_id);
	        $UG->setValue('user_id', $U->user_id);
	        $UG->save();
	    }
	}
	
	/**
	 * Sets all user member variables to the data provided
	 * 
	 * @param array $data
	 */
	private function setGroupData($data){
	    
	    $this->setValue('group_id', $data['group_id']);
	    $this->setValue('group_name', $data['group_name']);
	    $this->setValue('date_created', $data['date_created']);
	    $this->setValue('member_count', $data['member_count']);
	    $this->setValue('active', $data['active']);
	    
	}
	
	
	/*
	 * Set the current sessions active group the the currently loaded group
	 */
	private function setSession(){
	    $_SESSION['active_group'] = $this->group_id;
	}
	
	/**
	 * Sets the current group based on the sessions active group
	 *  
	 */
	private function setFromSession(){
	    
	}
	
	/**
	 * Returns an array of group data from the member variables.
	 * 
	 * @return array
	 */
	public function returnGroup(){
	    
	    if($this->group_id){
        	    $group['group_id'] = $this->user_id;
        	    $group['group_name'] = $this->user_name;
        	    $group['date_created'] = $this->user_email;
        	    $group['member_count'] = $this->date_created;
        	    $group['active'] = $this->active;
	    }else{
	        $group = array();
	    }
	    
	    return $group;
	    
	}
	
	public function incrementMemberCount($group_id){
	    
	    $q = "UPDATE `groups` SET member_count=member_count + 1 WHERE group_id = '".$group_id."'";
	    $this->qexec($q);
	    
	}
	
}

?>