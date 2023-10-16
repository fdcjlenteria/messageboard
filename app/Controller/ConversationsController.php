<?php

class ConversationsController extends AppController {
	public function index($messageId) {
		if (!$messageId) {
			$this->redirect(array('controller' => 'users', 'action' => 'index'));
		}
		$this->loadModel('Message');
		$message = $this->Message->findById($messageId);
		if (!$message) {
			$this->redirect(array('controller' => 'users', 'action' => 'index'));
		}

		$conversations = $this->Conversation->find('all', array(
			'conditions' => array(
				'message_id' => $messageId
			),
			'order' => ['Conversation.created ASC'],
			'limit' => 10
		));
		$userId = $message['Message']['user_id'];
		$recipientId = $message['Message']['recipient_id'];
		$messageId = $message['Message']['id'];
		$messageData = array(
			'user_id' => $userId,
			'recipient_id' => $recipientId,
			'message_id' => $messageId
		);
		$this->set(compact('conversations', 'messageData'));
	}

	public function reply() {
		$this->autoRender = false;
		if ($this->request->is('ajax')) {
			$senderId = $this->Auth->user('id');
			$ajaxData = $this->request->data;

			if (empty($ajaxData['reply'])) {
				$this->Session->setFlash('Invalid reply.', 'default', array(), 'error');
			} else {
				$this->Conversation->create();
				if (!$this->Conversation->save($ajaxData)) {
					$this->Session->setFlash('Something went wrong.', 'default', array(), 'error');
				}
			}
			echo json_encode(array(
				'url' => '/messageboard/conversations/index/' // send url to redirect
			));
		}
	}
	public function delete($convoId) {
		$this->autoRender = false;
		if ($this->request->is('ajax')) {
			$this->Conversation->delete($convoId);
			echo json_encode(array(
				'success' => true
			));
		}
	}

	public function showMore () {
		$this->autoRender = false;
		$offset = $this->request->query('offset');
		$messageId = $this->request->query('messageId');
		$conversations = $this->Conversation->find('all', array(
			'conditions' => array(
				'message_id' => $messageId
			),
			'order' => ['Conversation.created ASC'],
			'limit' => 10,
			'offset' => $offset
		));

		echo json_encode($conversations);
	}
}