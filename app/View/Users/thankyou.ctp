<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
  <div class="text-center">
    <h2>Thank You</h2>
    <p>You successfully registered to messageboard, you can now login.</p>
    <?php echo $this->Html->link('Back To Hompage', array('controller' => 'users', 'action' => 'login'), array('class' => 'btn btn-block btn-primary mt-5', 'style' => 'width: 50%; margin: 0 auto')); ?>
  </div>
</div>