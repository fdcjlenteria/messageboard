<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 */
class User extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'minLength' => array(
        'rule' => array('minLength', 5),
				'message' => 'Name must be at least 5 characters',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'maxLength' => array(
				'rule' => array('maxLength', 20),
				'message' => 'Name must be at least 5-20 characters',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		
		'email' => array(
			'email' => array(
				'rule' => array('email'),
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
			'unique' => array(
				'rule' => 'isUnique',
				'message' => 'This email address is already in use.',
        //'message' => 'Your custom message here',
        //'allowEmpty' => false,
        //'required' => false,
        //'last' => false, // Stop validation after this rule
        //'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'password' => array(
			'required' => array(
				'rule' => array('notBlank'),
				'message' => 'Password is required'
			),
			'minLength' => array(
        'rule' => array('minLength', 8),
        'message' => 'Password must be at least 8 characters long'
      )
		),
		'password_confirm' => array(
			'required' => array(
					'rule' => array('notBlank'),
					'message' => 'Password confirmation is required'
			),
			'compare' => array(
					'rule' => array('comparePasswords', 'password', true),
					'message' => 'Passwords do not match'
			)
		),
		// for update password
		'old_password' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Please enter your old password.'
			)
		),
	);
	public function comparePasswords($password_confirm, $password_field, $strict = false) {
		$password = $this->data[$this->name][$password_field];
		$confirm_password = $password_confirm['password_confirm'];
		
		if ($strict) {
				return $password === $confirm_password;
		} else {
				return $password == $confirm_password;
		}
	}

	public function beforeSave($options = array()) {
		if (isset($this->data['User']['password'])) {
			$this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
		}
		return true;
	}
}
