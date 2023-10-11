<?php
class UsersController extends AppController {
  public function beforeFilter() {
    parent::beforeFilter();
    $this->Auth->allow('thankyou', 'profile');
  }

  public function index () {
    $this->set('title_for_layout', 'Home');
  }
  public function register() {
    $this->set('title_for_layout', 'Register');

    if ($this->Auth->user()) {
      $this->redirect('index');
    }
    if($this->request->is('post')) {
      $this->User->set($this->request->data);
      if ($this->User->validates()) {
        $this->User->create();
       if($this->User->save($this->request->data)){

        // make sure to redirect to thank you page after registration only
        $this->Session->write('isFromRegister', true);
        $this->redirect(array('action' => 'thankyou'));
       }else {
        $this->Session->setFlash('Error registering user.');
       }
      } else {
        $this->Session->setFlash('Validation failed. Please correct the errors.');
      }
    }
  }

  public function login () {
    $this->set('title_for_layout', 'Login');

    if ($this->request->is('post')) {
      if ($this->Auth->login()) {
        $this->User->id = AuthComponent::user('id');
        $this->User->saveField('last_login_at', date('Y-m-d H:i:s'));
        $this->redirect($this->Auth->redirect());
      }else {
        $this->Session->setFlash('Username or password is incorrect.');
      }
    }
  }
  public function logout () {
    $this->redirect($this->Auth->logout());
  }

  public function thankyou() {
    $this->set('title_for_layout', 'Thank you');
    $isFromRegister = $this->Session->read('isFromRegister');
    if (!$isFromRegister){
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
    $userId = AuthComponent::user('id');

    if ($this->request->is(array('post', 'put'))) {
      $this->User->id = $userId;
      if ($this->User->save($this->request->data)) {
        $this->redirect(array('action' => 'profile', $userId));
      } else {
        $this->setFlash('Error saving user.', 'error');
      }
    }

    $user = $this->User->findById($userId);
    $this->request->data = $user;
    $this->set('user', $user);
  }

  // Update Password
  public function updatePassword(){
    if ($this->request->is(array('put', 'post'))) {
      $user = $this->User->findById(AuthComponent::user('id'));
      // Check if the old password matches the stored password
      if ($this->Auth->password($this->request->data['User']['old_password']) === $user['User']['password']) {
        // Password match
        // check new password length
        if (strlen($this->request->data['User']['password']) < 8) {
          $this->setFlash('Password must be at least 8 characters long.', 'error');
          return;
        }
        // check new password confirmation
        if ($this->request->data['User']['password'] !== $this->request->data['User']['password_confirm']) {
          $this->setFlash('Passwords do not match', 'error');
          return;
        }

        $this->User->id = $user['User']['id'];
        if ($this->User->saveField('password', $this->request->data['User']['password'])) {
          $this->setFlash('Password updated successfully.', 'success');
        } else {
          $this->setFlash('Password update failed. Please try again.', 'error');
        }
      } else {
        $this->setFlash('Old password is incorrect. Please try again.', 'error');
      }
      $this->redirect($this->referer());
    }
  }

  public function setFlash($text, $type) {
    $this->Session->setFlash($text, 'default', array(), $type);
  }
}