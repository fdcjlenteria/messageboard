<style>
  .nav-link.dropdown-toggle::after {
    display: none;
  }
  #navbarDropdown {
    width: 40px;
    height: 40px;
    padding: 0px;
  }
  .avatar {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    border: 1px solid rgba(0,0,0,0.2);
  }
</style>
<?php
  if (empty(AuthComponent::user('photo_url'))) {
    $photoUrl = 'https://cdn-icons-png.flaticon.com/512/147/147142.png';
  } else {
    $photoUrl = $this->Html->webroot(AuthComponent::user('photo_url'));
  }
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <?php echo $this->Html->link('Messageboard', array('controller' => 'users', 'action' => 'index'), array('style' => 'text-decoration: none; color: black; font-size: 1.25rem;')); ?>
  <div class="ml-auto">
    <?php if(AuthComponent::user()): ?>
      <div class="dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img src="<?php echo $photoUrl; ?>" class="avatar" alt="User Profile">
        </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <?php
              echo $this->Html->link('Profile', array('controller' => 'users', 'action' => 'profile', AuthComponent::user('id')), array('class' => 'dropdown-item', 'style' => 'text-decoration: none; color: black;'));
              echo $this->Html->link('Account Settings', array('controller' => 'users', 'action' => 'edit'), array('class' => 'dropdown-item', 'style' => 'text-decoration: none; color: black;'));
              echo $this->Html->link('Update Password', array('controller' => 'users', 'action' => 'password'), array('class' => 'dropdown-item', 'style' => 'text-decoration: none; color: black;'));
              echo $this->Html->link('Update Email', array('controller' => 'users', 'action' => 'email'), array('class' => 'dropdown-item', 'style' => 'text-decoration: none; color: black;'));
            ?>
            <hr>
            <?php echo $this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout'), array('class' => 'dropdown-item')); ?>
          </div>
        </div>
      </div>
    <?php endif; ?>
</nav>