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
  #show-more{
    color: blue;
    cursor: pointer;
  }
  #show-more:hover{
    text-decoration: underline;
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
          <div class="card-body message-content-container p-0" data-message-id="<?php echo $message['Message']['id'] ?>">
            <div class="card mx-auto" style="width: 90%;">
              <div class="card-body row">
                <div class="col-md-1 mr-2">
                  <?php $photoUrl = $message['User']['photo_url'] 
                    ? '/messageboard/' . $message['User']['photo_url']
                    : 'https://cdn-icons-png.flaticon.com/512/147/147142.png' 
                    ?>
                  <img src="<?php echo $photoUrl; ?>" alt="" width="40px" height="40px">
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
                        <?= $message['Message']['created']; ?>
                      </small>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <?php if(count($messages) >= 10): ?>
        <div class="text-center mb-5">
          <a id="show-more" data-offset="10">Show More</a>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    var isLoading = false;
    var offset = $('#show-more').data('offset');

    // Show more pagination
    $('#show-more').on('click', function() {
      if (isLoading) {
        return;
      }
      isLoading = true;
      $('#show-more').text('Loading...');
        
      $.ajax({
        url: '/messageboard/users/showMore?offset=' + offset,
        type: 'GET',
        dataType: 'json',
        success: function(data) {
          if(data.length > 0) {
            data.forEach(function(d) {
              d.User.photo_url = d.User.photo_url ? '/messageboard/' + d.User.photo_url : 'https://cdn-icons-png.flaticon.com/512/147/147142.png'
              const html = `
              <div class="card-body message-content-container p-0" data-message-id="${d.Message.id}">
                <div class="card mx-auto" style="width: 90%;">
                  <div class="card-body row">
                    <div class="col-md-1 mr-2">
                      <img src="${d.User.photo_url}" alt="" style="width: 100%">
                    </div>
                    <div class="col-md-10">
                      <div class="d-block">
                        <div class="text-left body-message">
                          <p>
                            ${d.Message.content}
                          </p>
                        </div>
                        <div class="date text-right">
                          <small class="text-muted">
                            ${d.Message.created}
                          </small>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              `;
              $('.message-content').append(html);
            })
            offset += data.length;
            $('#show-more')
              .text('Show More')
              .data('offset', offset);
          }else {
            $('#show-more').hide();
          }

          isLoading = false;
        },
        error: function() {
          isLoading = false;
        }
      })
    })

    // direct to conversation
    $('.container').on('click', '.message-content-container', function() {
      const messageId = $(this).data('message-id');
      window.location.href = `/messageboard/conversations/index/${messageId}`;
    })
  })
</script>