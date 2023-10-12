<style>
  #upload-label {
    display: inline-block;
    padding: 0px 15px;
    background-color: lightGray;
    color: black;
    border: 1px solid rgba(0,0,0,0.5);
    border-radius: 5px;
    cursor: pointer;
    text-align: center;
    font-size: 12px;
    text-decoration: none;
    margin-left: 10px;
  }
  form label:after {
    color: #e32;
    content: '*';
    display:inline;
  }
  label[for="photo-url"] {
    display: none;
  }

  input#photo-url {
      display: none;
  }
</style>
<?php
  if (empty($user['User']['photo_url'])) {
    $photoUrl = 'https://cdn-icons-png.flaticon.com/512/147/147142.png';
  } else {
    $photoUrl = $this->Html->webroot($user['User']['photo_url']);
  }
?>
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
      <?php echo $this->Form->create('User', array('type' => 'file')); ?>
      <div class="d-flex justify-content-center align-items-center" style="width: 50%; margin: 0 auto; text-align: center;">
        <img id="image-preview" src="<?php echo $photoUrl; ?>" style="max-width: 150px;" />
        <label for="photo-url" id="upload-label">Upload Pic</label>
      </div>
      <?php
        echo $this->Form->input('photo_url', array('id' => 'photo-url', 'name' => 'data[User][photo_url]', 'accept' => '.jpg, .png, .gif', 'type' => 'file'));
        echo $this->Form->input('name', array('required', 'class' => 'form-control', 'minlength' => 5, 'maxlength' => 20, 'div' => array('class' => 'form-group')));
        echo $this->Form->input('birthdate', array(
          'required',
          'type' => 'text',
          'class' => 'form-control datepicker',
          'div' => array('class' => 'form-group')
        ));
        echo $this->Form->input('gender', array('required', 'options' => array('m' => 'Male', 'f' => 'Female'), 'class' => 'form-control', 'div' => array('class' => 'form-group')));
        echo $this->Form->input('hobby', array('required', 'class' => 'form-control', 'div' => array('class' => 'form-group')));
        echo $this->Form->submit('Update', array('required', 'class' => 'btn btn-success btn-block mt-3','style' => 'width: auto'));
        echo $this->Form->end();
      ?>
    </div>
  </div>
</div>
<script>
  
  $(document).ready(function() {
    // Image preview
    $("#photo-url").change(function () {
      readURL(this);
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $("#image-preview").attr("src", e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    // date picker
    $('.datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        yearRange: '-100:+0',
    });
  })
</script>