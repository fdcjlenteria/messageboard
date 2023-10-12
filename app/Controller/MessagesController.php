<?php
class MessagesController extends AppController {
  public function index() {
    
  }
  public function new () {
    $this->set('title_for_layout', 'New Message');
    // create
    if ($this->request->is(array('post', 'put'))) {
      if (empty($this->request->data['Message']['recipient'])) {
        $this->setFlash('Please provide recipient.', 'error');
      }else {
        $this->Message->create();
        $this->request->data['Message']['user_id'] = $this->Auth->user('id');

        if ($this->Message->save($this->request->data)) {
           $this->redirect(array('controller' => 'users','action' => 'index'));
        } else {
          $this->setFlash('Message creation failed. Please try again.', 'error');
        }
      }
    }

    $this->loadModel('User');
    $users = $this->User->find('all', array(
      'fields' => array(
        'User.id',
        'User.name',
        'User.photo_url'
      ),
      'recursive' => -1
    ));
    $this->set('users', $users);
  }

  public function delete() {

  }
  public function setFlash($text, $type = 'error') {
    $this->Session->setFlash($text, 'default', array(), $type);
  }
}