<?php

class Conversation extends AppModel {
  public $belongsTo = array('Message', 'User');
}