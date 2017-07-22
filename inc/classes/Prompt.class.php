<?php
class Prompt{
	private $_db;
	private $_prompt;
	private $_user;
	public function __construct($user){
		$this->_user = $user;
		$this->_db = DB::getInstance();
		$this->get($user);
	}
	public function get($user, $id = null){
		if($id){
			$this->_prompt = $this->_db->get("prompt", ["id", "=", $id])->first();
		}else{
			$this->_prompt = $this->_db->get("prompt", ["uid", "=", $user])->results();
		}
	}
	public function getPrompt($id = null){
		if($id){
			$this->get($this->_user, $id);
			return $this->_prompt;
		}
		return $this->_prompt;
	}
	public function add($user, $prompt){
		$this->_db->insert("prompt", ["uid"=>$user, "prompt" =>$prompt, "hash"=>Hash::unique_length(8)]);
	}
} 