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

    .message-body {
        display: flex;
    }
    .message-body #show-more-content {
        display: none;
        text-decoration: underline;
        margin-left: 10px; 
    }
</style>

<div class="container">
    <div class="messages mt-5 mb-5">
        <div class="d-flex justify-content-between">
            <p></p>
            <?php echo $this->Html->link('New Message', array('controller' => 'messages', 'action' => 'new'), array('class' => 'btn btn-success btn-block mb-2', 'style' => 'width: auto;')); ?>
        </div>
        <div class="card">
            <div class="card-header mb-5">
                <div class="d-flex align-items-center">
                    <h5 class="card-title mb-0 mr-3">Message Lists</h5>
                    <input type="text" class="form-control" id="search-message" placeholder="Search ..." style="width: 50%">
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
                                        <div class="text-left message-body">
                                            <p>
                                                <?php echo $message['Message']['content']; ?>
                                            </p>
                                            <a id="show-more-content">Show More</a>
                                        </div>
                                        <div class="date text-right">
                                            <small class="text-muted">
                                                <?php echo $message['Message']['created']; ?>
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
                    <a id="show-more" data-limit="20">Show More</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
  $(document).ready(function() {
    // for long messages
    function initLongMessages() {
      $('.container .message-body').each(function() {
        const pElement = $(this).find('p');
        const msgFullText = pElement.text().trim();
        if(msgFullText.length > 50) {
            var truncatedText = msgFullText.substring(0, 50) + "...";
            var isTruncated = true;
            $(pElement).text(truncatedText);
            $(this).find('a').show();

            $(this).find('a').on('click', function(el) {
                if (isTruncated) {
                    $(pElement).text(msgFullText);
                    $(this).parent().find('a').text('Show less');
                }else {
                    $(pElement).text(truncatedText);
                    $(this).parent().find('a').text('Show more');
                }
                isTruncated = !isTruncated;
            })
        }
  
      })
    }

    //get messages
    var isLoading = false;
    var limit = $('#show-more').data('limit');
    // Show more pagination
    $('#show-more').on('click', function() {
        if (isLoading) {
            return;
        }
        isLoading = true;
        $('#show-more').text('Loading...');
        getMessages();
    })

    //search message
    $('#search-message').on('keyup', function() {
        if (isLoading) {
            return;
        }
        isLoading = true;
        limit = 10;
        $('.message-content').empty();
        getMessages();
    })
    function getMessages() {
        const query = $('#search-message').val();
        if (query !== '') {
            $('#show-more').hide();
        }
        $.ajax({
            url: '/messageboard/users/getMessages/' + limit + '?q=' + query,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                const messageContainer = $('.message-content');
                const oldMessageContent = messageContainer.html();
                messageContainer.empty();
                if(data.length > 0) {
                    // if query is not empty and the data is less than equal to 9 then hide the show more button
                    if (query !== '') {
                        if (data.length <= 9) {
                            $('#show-more').hide();
                        } else { // show if the data is greater than 10
                            $('#show-more').show();
                        }
                    } else {
                        $('#show-more').show();
                    }
                    data.forEach(function(d) {
                        d.User.photo_url = d.User.photo_url 
                            ? '/messageboard/' + d.User.photo_url 
                            : 'https://cdn-icons-png.flaticon.com/512/147/147142.png'

                        const html = `
                            <div class="card-body message-content-container p-0" data-message-id="${d.Message.id}">
                                <div class="card mx-auto" style="width: 90%;">
                                    <div class="card-body row">
                                        <div class="col-md-1 mr-2">
                                            <img src="${d.User.photo_url}" alt="" width="40px" height="40px">
                                        </div>
                                        <div class="col-md-10">
                                            <div class="d-block">
                                                <div class="text-left message-body">
                                                    <p>
                                                        ${d.Message.content}
                                                    </p>
                                                    <a id="show-more-content">Show More</a>
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
                            </div> `;
                        messageContainer.append(html)
                    })
                    initLongMessages();
                    limit += 10;
                    $('#show-more')
                    .text('Show More')
                    .data('limit', limit);

                    if ($(messageContainer.html()).length == $(oldMessageContent).length) {
                        $('#show-more').hide();
                    }
                }
                 else {
                    if (query !== '') {
                        messageContainer.append(`<p class="text-center text-danger">-- Message Not Found -- </p>`)
                    }
                    $('#show-more').hide();
                }

                isLoading = false;
            },
            error: function() {
                isLoading = false;
            }
        })
    }

    // direct to conversation
    $('.container').on('click', '.message-content-container', function(event) {
        if (!$(event.target).is('a')) { // prevent opening if clicking 'show more' or 'show less'
            const messageId = $(this).data('message-id');
            window.location.href = `/messageboard/conversations/index/${messageId}`;
        }
    })
    initLongMessages();
  })
</script>