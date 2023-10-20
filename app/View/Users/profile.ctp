<style>
	p {
		margin-bottom: 5px;
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
	<div class="card mt-5">
		<div class="card-header">
			<h4 class="card-title text-center">User Profile</h4>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-md-4 offset-md-1 mr-3" style="border: 1px solid rgba(0,0,0,0.4); padding: 5px;">
					<div class="text-center">
						<img src="<?php echo $photoUrl; ?>" width="180" height="180">
					</div>
				</div>
				<div class="col-md-6">
					<div class="text-left">
						<div class="block">
							<h4 class="mb-2"><strong><?php echo $user['User']['name']; ?></strong></h4>
							<p><strong>Email: </strong> <?php echo $user['User']['email']; ?></p>
							<p><strong>Gender:</strong>
								<?php if ($user['User']['gender'] == 'm'): ?>
									Male
								<?php else: ?>
									Female
								<?php endif; ?>
							</p>
							<p><strong>Birthdate: </strong> 
								<?php if ($user['User']['birthdate']): ?>
									<?php echo $user['User']['birthdate'];?>
								<?php else:?>
									N/A
								<?php endif;?>
							</p>
							<p><strong>Joined: </strong> <?php echo $user['User']['created']; ?></p>
							<p><strong>Last Login: </strong> 
								<?php if ($user['User']['last_login_at']): ?>
									<?php echo $user['User']['last_login_at'];?>
								<?php else:?>
									N/A
								<?php endif;?>
							</p>
							<div class="d-flex mt-4">
								<?php echo $this->Html->link('Edit Profile', array('controller' => 'users', 'action' => 'edit'), array('class' => 'btn btn-secondary mr-2'));?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-md-12">
					<h4>Hobby</h4>
					<?php if($user['User']['hobby']): ?>
						<div style="text-align: left; background: rgba(0,0,0,0.1); padding: 20px">
							<p>
								<?php echo $user['User']['hobby']; ?>
							</p>
						</div>
					<?php endif;?>
				</div>
			</div>
		</div>
	</div>
</div>