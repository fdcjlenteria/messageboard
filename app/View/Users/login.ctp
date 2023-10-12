<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
  <div class="border shadow p-4 rounded" style="width: 400px;">
      <h2 class="text-center">Login Form</h2>
      <?php if ($this->Session->check('Message.error')): ?>
        <div class="alert alert-danger">
          <?php echo $this->Session->flash('error'); ?>
        </div>
      <?php endif;?>

      <?php 
        echo $this->Form->create('User', array('class' => 'mt-3')); 
        echo $this->Form->input('email', array('class' => 'form-control', 'div' => array('class' => 'form-group')));
        echo $this->Form->input('password', array('class' => 'form-control', 'div' => array('class' => 'form-group')));
        echo $this->Form->button('Login', array('class' => 'btn btn-success btn-block mt-3'));
        echo $this->Form->end();
      ?>
      <div class="text-center">
        <small>OR</small>
        <?php echo $this->Html->link('Register', array('controller' => 'users', 'action' => 'register'), array('class' => 'btn btn-primary btn-block')); ?>
      </div>
  </div>
</div>


