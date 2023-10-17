<?php

class Conversation extends AppModel {
  public $belongsTo = array('Message', 'User');
  
  // set timezone to Philippines
	public function beforeSave($options = []) {
		if (!$this->id) {
			$timezone = 'Asia/Manila';
			$currentTime = new DateTime('now', new DateTimeZone($timezone));
			$this->data[$this->alias]['created'] = $currentTime->format('Y-m-d H:i:s');
		}
		return true;
	}
}