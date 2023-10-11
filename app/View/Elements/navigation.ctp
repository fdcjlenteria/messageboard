<style>
  .nav-link.dropdown-toggle::after {
    display: none;
  }
</style>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <?php echo $this->Html->link('Messageboard', array('controller' => 'users', 'action' => 'index'), array('style' => 'text-decoration: none; color: black; font-size: 1.25rem;')); ?>
  <div class="ml-auto">
    <?php if(AuthComponent::user()): ?>
      <div class="dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img src="https://cdn-icons-png.flaticon.com/512/147/147142.png" class="avatar" alt="User Profile" class="img-fluid rounded-circle" height="40" width="40">
        </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <?php
              echo $this->Html->link('Profile', array('controller' => 'users', 'action' => 'profile', AuthComponent::user('id')), array('class' => 'dropdown-item', 'style' => 'text-decoration: none; color: black;'));
              echo $this->Html->link('Account Settings', array('controller' => 'users', 'action' => 'edit'), array('class' => 'dropdown-item', 'style' => 'text-decoration: none; color: black;'));
              echo $this->Html->link('Update Password', array('controller' => 'users', 'action' => 'updatePassword'), array('class' => 'dropdown-item', 'style' => 'text-decoration: none; color: black;'));
              echo $this->Html->link('Update Email', array('controller' => 'users', 'action' => 'updateEmail'), array('class' => 'dropdown-item', 'style' => 'text-decoration: none; color: black;'));
            ?>
            <hr>
            <?php echo $this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout'), array('class' => 'dropdown-item')); ?>
          </div>
        </div>
      </div>
    <?php endif; ?>
</nav>