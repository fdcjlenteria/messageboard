<?php
class UsersController extends AppController {
	public $components = array('RequestHandler');
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('thankyou', 'profile');
	}

	public function index() {
		$this->set('title_for_layout', 'Home');

		$messages = $this->User->Message->find('all', array(
			'conditions' => array(
				'OR' => array(
				'user_id' => $this->Auth->user('id'), // main sender can see the conversation
				'recipient_id' => $this->Auth->user('id') // recipient also can see the conversation
				)
			),
			'order' => ['Message.created ASC'],
			'limit' => 10
		));
		$this->set('messages', $messages);
	}

	public function getMessages($limit = 10) {
		$this->autoRender = false;
		$query = $this->request->query('q');
		$pattern = '%' . $query . '%';
		$messages = $this->User->Message->find('all', array(
			'conditions' => array (
				'Message.content LIKE' => $pattern
			),
			'order' => ['Message.created ASC'],
			'limit' => $limit
		));
		echo json_encode($messages);
	}
	
	public function register() {
		$this->set('title_for_layout', 'Register');

		if ($this->Auth->user()) {
			$this->redirect('index');
		}
		if ($this->request->is('post')) {
			$this->User->set($this->request->data);
			if ($this->User->validates()) {
					$this->User->create();
				if ($this->User->save($this->request->data)){
					// make sure to redirect to thank you page after registration only
					$this->Session->write('isFromRegister', true);
					$this->redirect(array('action' => 'thankyou'));
				} else {
					$this->setFlash('Error registering user.', 'error');
				}
			} else {
				$this->setFlash('Validation failed. Please correct the errors.', 'error');
			}
		}
	}

	public function login() {
		$this->set('title_for_layout', 'Login');

		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				$this->User->id = $this->Auth->user('id');
				$this->User->saveField('last_login_at', date('Y-m-d H:i:s'));
				$this->redirect($this->Auth->redirect());
			} else {
				$this->setFlash('Username or password is incorrect.', 'error');
			}
		}
	}
	public function logout() {
		$this->redirect($this->Auth->logout());
	}

	public function thankyou() {
		$this->set('title_for_layout', 'Thank you');
		$isFromRegister = $this->Session->read('isFromRegister');
		if (!$isFromRegister) {
			$this->redirect('index');
		}
		$this->Session->delete('isFromRegister');
	}

	// User Profile
	public function profile($userId = null) {
		$this->set('title_for_layout', 'Profile');

		$this->set('title_for_layout', 'Profile');
		$user = $this->User->findById($userId);
		
		if (!$user) {
			$this->redirect('index');
		}
		$this->set('user', $user);
	}

	// User Account Settings
	public function edit() {
		$this->set('title_for_layout', 'Account Settings');
		$userId = $this->Auth->user('id');
		$user = $this->User->findById($userId);

		if ($this->request->is(array('post', 'put'))) {
			$file = $this->request->data['User']['photo_url'];
			$this->request->data['User']['photo_url'] = $user['User']['photo_url'];
			
			if (empty($user['User']['photo_url']) && empty($file['name'])
				|| empty($this->request->data['User']['name'])
				|| empty($this->request->data['User']['birthdate'])
				|| empty($this->request->data['User']['gender'])
				|| empty($this->request->data['User']['hobby'])
			) {
				return $this->setFlash('Please fill up all fields.');
			}
			if ($file['name']) {
				$fileExt = pathinfo($file['name'], PATHINFO_EXTENSION);
				$filename = 'profile_' . $userId . '.' . $fileExt;
				$targetDir = WWW_ROOT . 'img' . DS . 'profiles' . DS . $filename;
				$existingImgPath = WWW_ROOT . 'img/profiles/' . $filename;
				if (file_exists($existingImgPath)) {
					unlink($existingImgPath);
				}

				if (move_uploaded_file($file['tmp_name'], $targetDir)) {
					$this->request->data['User']['photo_url'] = 'img/profiles/' . $filename;
				} else {
					$this->setFlash('Error uploading photo.', 'error');
				}
			}
			// save 
			$this->User->id = $userId;
			if ($this->User->save($this->request->data)) {
				$this->redirect(array('action' => 'profile', $userId));

			} else {
				$this->setFlash('Error saving user.', 'error');
			}
		}
		$this->request->data = $user;
		$this->set('user', $user);
	}

	// Update Password
	public function password(){
		if ($this->request->is(array('put', 'post'))) {
			$userId = $this->Auth->user('id');
			$this->User->set($this->request->data);
			if ($this->User->validates()) {
				$this->User->id = $userId;
				if ($this->User->saveField('password', $this->request->data['User']['password'])) {
					$this->setFlash('Password successfully updated.', 'success');
				} else {
					$this->setFlash('Email update failed. Please try again.', 'error');
				}
			} else {
				$this->setFlash('Validation failed. Please correct the errors.', 'error');
			}
		}
	}

	public function email() {
		$userId = $this->Auth->user('id');
		// remove rules for old email
		$this->User->validate['email'] = array();
		
		if ($this->request->is(array('put', 'post'))) {
			$this->User->set($this->request->data);

			if ($this->User->validates()) {
				$this->User->id = $userId;
				if ($this->User->saveField('email', $this->request->data['User']['new_email'])) {
					$this->setFlash('Email updated successfully.', 'success');
				} else {
					$this->setFlash('Email update failed. Please try again.', 'error');
				}
			}
		}
		$user = $this->User->findById($userId);
		$this->request->data = $user;
		$this->set('user', $user);
	}

	public function setFlash($text, $type = 'error') {
		$this->Session->setFlash($text, 'default', array(), $type);
	}


	//get the updated profile pic for the Authenticated user 
	public function getAuthPhotoUrl($id) {
		$this->autoRender = false;
		$user = $this->User->findById($id);
		if (!$user) {
			$this->logout(); // call logout if user is not found
		}
		return $user['User']['photo_url'];
	}
}