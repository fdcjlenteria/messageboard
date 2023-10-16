<?php echo $this->Html->css('form'); ?>
<div class="container">
    <?php echo $this->element('navigation'); ?>
    <div class="card mt-5">
        <div class="card-header">
            <h4 class="card-title text-center">Update Email</h4>
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
                echo $this->Form->input('email', array('readonly', 'label' => 'Current Email', 'class' => 'form-control', 'div' => array('class' => 'form-group')));
                echo $this->Form->input('new_email', array('value' => '', 'type' => 'email','class' => 'form-control', 'div' => array('class' => 'form-group')));
                echo $this->Form->submit('Update Email', array('class' => 'btn btn-success btn-block mt-3','style' => 'width: auto'));
                echo $this->Form->end();
            ?>
        </div>
    </div>
</div>