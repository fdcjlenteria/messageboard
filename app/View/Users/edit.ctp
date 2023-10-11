<?php echo $this->Html->css('form.css'); ?>

<div class="container">
  <?php echo $this->element('navigation'); ?>
  <div class="card mt-5">
    <div class="card-header">
      <h4 class="card-title text-center">Account Settings</h4>
    </div>
    <div class="card-body">
      <?php if ($this->Session->check('Message.error')): ?>
        <div class="alert alert-danger">
          <?php echo $this->Session->flash('error'); ?>
        </div>
      <?php endif;?>

      <?php
        echo $this->Form->create('User'); 
        echo $this->Form->input('name', array('class' => 'form-control', 'div' => array('class' => 'form-group')));
        echo $this->Form->input('birthdate', array('class' => 'form-control', 'div' => array('class' => 'form-group')));
        echo $this->Form->input('gender', array('options' => array('m' => 'Male', 'f' => 'Female'), 'class' => 'form-control', 'div' => array('class' => 'form-group')));
        echo $this->Form->input('hobby', array('class' => 'form-control', 'div' => array('class' => 'form-group')));
        echo $this->Form->input('profile_url', array('type' => 'file', 'class' => 'form-control', 'div' => array('class' => 'form-group')));
        echo $this->Form->submit('Update', array('class' => 'btn btn-success btn-block mt-3','style' => 'width: auto'));
        echo $this->Form->end();
      ?>
    </div>
  </div>
</div>