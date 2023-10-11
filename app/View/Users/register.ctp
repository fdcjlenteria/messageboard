<?php echo $this->Html->css('form.css'); ?>
<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
  <div class="border shadow p-4 rounded" style="width: 400px;">
      <h2 class="text-center">Registration Form</h2>
      <?php if ($this->Session->check('Message.flash')): ?>
        <div class="alert alert-danger">
          <?php echo $this->Flash->render(); ?>
        </div>
      <?php endif;?>
      <?php 
        echo $this->Form->create('User', array('class' => 'mt-3')); 
        echo $this->Form->input('name', array('label' => 'Full Name', 'class' => 'form-control', 'div' => array('class' => 'form-group')));
        echo $this->Form->input('email', array('class' => 'form-control', 'div' => array('class' => 'form-group')));
        echo $this->Form->input('password', array('type' => 'password','class' => 'form-control', 'div' => array('class' => 'form-group')));
        echo $this->Form->input('password_confirm', array('type' => 'password','class' => 'form-control', 'div' => array('class' => 'form-group')));
        echo $this->Form->button('Register', array('class' => 'btn btn-primary btn-block' ));
        echo $this->Form->end();
      ?>
      <div class="text-center">
        <small>OR</small>
        <?php echo $this->Html->link('Login', array('controller' => 'users', 'action' => 'login'), array('class' => 'btn btn-success btn-block')); ?>
      </div>
  </div>
</div>