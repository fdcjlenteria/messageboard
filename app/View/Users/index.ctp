<style>
  .message-content-container{
    margin-bottom: 15px;
  }
  .message-content-container .row {
    cursor: pointer;
  }
  .message-content-container .row:hover {
    opacity: 0.7;
  }
</style>

<div class="container">
  <?php echo $this->element('navigation'); ?>
  <div class="messages mt-5 mb-5">
    <div class="d-flex justify-content-between">
        <p></p>
        <?php echo $this->Html->link('New Message', array('controller' => 'messages', 'action' => 'new'), array('class' => 'btn btn-success btn-block mb-2', 'style' => 'width: auto;')); ?>
    </div>
    <div class="card">
      <div class="card-header mb-5">
        <div class="d-flex align-items-center">
          <h5 class="card-title mb-0 mr-3">Message Lists</h5>
          <input type="text" class="form-control" placeholder="Search ..." style="width: 50%">
        </div>
      </div>
      <div class="message-content">
        <?php foreach($messages as $index => $message): ?>
          <div class="card-body message-content-container p-0">
            <div class="card mx-auto" style="width: 90%;">
              <div class="card-body row">
                <div class="col-md-1 mr-2">
                  <img src="https://cdn-icons-png.flaticon.com/512/147/147142.png" alt="" style="width: 100%">
                </div>
                <div class="col-md-10">
                  <div class="d-block">
                    <div class="text-left body-message">
                      <p>
                        <?php echo $message['Message']['content']; ?>
                      </p>
                    </div>
                    <div class="date text-right">
                      <small class="text-muted">
                        <?php echo $message['Message']['created'];?>
                      </small>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <?php if(count($messages) >= 5): ?>
        <div class="text-center mb-5">
          <a id="show-more">Show More</a>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    var offset = 0;
    var isLoading = false;

    $('#show-more').on('click', function() {
      if (isLoading) {
        return;
      }
      isLoading = true;
      $('#show-more').text('Loading...');
      $.ajax({
        url: '/messageboard/get-messages?offset=' + offset,
        type: 'GET',
        dataType: 'json',
        success: function(data) {
          if(data.length > 0) {
            data.forEach(function(msg) {
              $()
            })

            offset += data.length;
          }else {
            $('#show-more').text('No more items');
          }

          isLoading = false;
        },
        error: function() {
          isLoading = false;
          $('#show-more').text('Error');
        }
      })
    })
  })
</script>