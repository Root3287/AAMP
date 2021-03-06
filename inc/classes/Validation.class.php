<?php
class Validation{
	private $_passed = false, $_errors = array(), $_db = null;
	public function __construct(){
		if(isset($GLOBALS['config'])){
			$this->_db = DB::getInstance();
		}
	}
	public function check($source, $items = array()){
		foreach ($items as $item=>$rules){
			foreach ($rules as$rule =>$rule_value){
				$value = $source[$item];
				$item = escape($item);
				if($rule === 'required' && empty($value)){
					$this->addError("{$item} is required");
				}else if(!empty($value)){
					switch ($rule){
						case 'min':
							if(strlen($value) < $rule_value){
								$this->addError("{$item} must be a minimum of {$rule_value}");
							}
							break;
						case 'max':
							if(strlen($value) > $rule_value){
								$this->addError("{$item} must be a maximum of {$rule_value}");
							}
							break;
						case 'matches':
							if($value != $source[$rule_value]){
								$this->addError("{$rule_value} must match {$item}");
							}
							break;
						case 'unique':
							$check = $this->_db->get($rule_value, array($item , '=' , $value));
							if($check->count()){
								$this->addError("{$item} already exsits!");
							}
							break;
						case 'spaces':
							if ((count(explode(' ', $value)) > 1) && !$rule_value) {
  								$this->addError("{$item} may not contain any spaces");
							}
							break;
						case 'isactive':
							$check = $this->_db->get('users', [$item, '=', $value]);
							if($check->count()){
								$isActive = $check->first()->active;
								if($isActive == 0){
									$this->addError("This username is inactivated.");
								}
							}
							break;
						case 'isbanned':
							$check = $this->_db->get('users', [$item, '=', $value]);
							if($check->count()){
								$isbanned = $check->first()->banned;
								if($isbanned == 1){
									$this->addError("This user has been banned.");
								}					
							}
							break;
					}
				}
			}
		}
		if(empty($this->_errors)){
			$this->_passed = true;
		}
		return $this;
	}
	
	public function addError($error){
		$this->_errors[] = $error;
	}
	public function errors() {
		return $this->_errors;
	}
	public function passed() {
		return $this->_passed;
	}
}