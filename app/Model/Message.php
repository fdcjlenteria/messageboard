<?php
App::uses('AppModel', 'Model');
/**
 * Message Model
 *
 */
class Message extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';
	public $belongsTo = 'User';
	public $hasMany = array(
		'Conversation' => array(
      'className' => 'Conversation',
      'foreignKey' =>'message_id',
			'dependent' => true
    )
	);
/**
 * Validation rules
 *
 * @var array
 */

	public $validate = array(
		'id' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'content' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

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
