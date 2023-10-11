<div class="container">
  <?php echo $this->element('navigation'); ?>
  <div class="messages mt-5">
    <div class="d-flex justify-content-between">
        <p></p>
        <?php echo $this->Html->link('New Message', array('controller' => 'messages', 'action' => 'new'), array('class' => 'btn btn-success btn-block mb-2', 'style' => 'width: auto;')); ?>
    </div>
    <div class="card">
      <div class="card-header">
        <div class="d-flex align-items-center">
          <h5 class="card-title mb-0 mr-3">Message Lists</h5>
          <input type="text" class="form-control" placeholder="Search ..." style="width: 50%">
        </div>
      </div>
      <div class="card-body">
      </div>
    </div>
  </div>
</div>