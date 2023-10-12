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
	public $hasMany = 'Message';
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
			),
			'checkOldPassword' => array(
				'rule' => 'checkOldPassword',
				'message' => 'The old password is incorrect.',
			)
		),
		'new_email' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'checkNewEmail' => array(
        'rule' => 'checkNewEmail',
        'message' => 'This is your old email, please input a new one.'
        //'message' => 'Your custom message here',
        //'allowEmpty' => false,
			),
			'checkUnique' => array(
        'rule' => 'checkUnique',
				'message' => 'This email address is already in use.',
        //'message' => 'Your custom message here',
        //'allowEmpty' => false,
			)
		)
	);

	public function comparePasswords($passwordConfirm, $passwordField, $strict = false) {
		$password = $this->data[$this->name][$passwordField];
		$confirm_password = $passwordConfirm['password_confirm'];
		
		if ($strict) {
				return $password === $confirm_password;
		} else {
				return $password == $confirm_password;
		}
	}
	public function checkOldPassword($data) {
		$userId = AuthComponent::user('id');
		$user = $this->findById($userId);
		$hashedOldPassword = AuthComponent::password($data['old_password']);
		return $user['User']['password'] === $hashedOldPassword;
	}

	public function checkNewEmail($data) {
		$userId = AuthComponent::user('id');
		$user = $this->findById($userId);

		$oldEmail = $user['User']['email'];
		
		if ($data['new_email'] === $oldEmail) { 
			return false; 
		}
		return true;
	}
	public function checkUnique($data) {
		$user = $this->findByEmail($data['new_email']);
		if ($user) { 
			return false; 
		}
		return true;
	}

	public function beforeSave($options = array()) {
		if (isset($this->data['User']['password'])) {
			$this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
		}
		return true;
	}
}
