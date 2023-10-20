<?php echo $this->Html->css('form'); ?>
<div class="container">
	<div class="card mt-5">
		<div class="card-header">
			<h4 class="card-title text-center">Update Password</h4>
		</div>
		<div class="card-body">
			<?php if ($this->Session->check('Message.error')): ?>
				<div class="alert alert-danger">
					<?php echo $this->Session->flash('error'); ?>
				</div>
			<?php endif;?>
			<?php if ($this->Session->check('Message.success')): ?>
				<div class="alert alert-success">
					<?php echo $this->Session->flash('success'); ?>
				</div>
			<?php endif;?>

			<?php
				echo $this->Form->create('User'); 
				echo $this->Form->input('old_password', array('value' => '', 'type' => 'password','label' => 'Enter your current password', 'class' => 'form-control', 'div' => array('class' => 'form-group')));
				echo $this->Form->input('password', array('value' => '', 'type' => 'password','class' => 'form-control', 'div' => array('class' => 'form-group')));
				echo $this->Form->input('password_confirm', array('value' => '', 'type' => 'password','class' => 'form-control', 'div' => array('class' => 'form-group')));
				echo $this->Form->submit('Update Password', array('class' => 'btn btn-success btn-block mt-3','style' => 'width: auto'));
				echo $this->Form->end();
			?>
		</div>
	</div>
</div>