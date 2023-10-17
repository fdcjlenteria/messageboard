<style>
	.message-recipient-label:after{
		color: #e32;
		content: '*';
		display:inline;
	}
</style>

<?php echo $this->Html->css('form'); ?>
<div class="container">
	<?php echo $this->element('navigation'); ?>
	<div class="card mt-5">
		<div class="card-header">
			<h4 class="card-title text-center">New Message</h4>
		</div>
		<div class="card-body">
			<?php if ($this->Session->check('Message.error')): ?>
				<div class="alert alert-danger">
					<?php echo $this->Session->flash('error'); ?>
				</div>
			<?php endif;?>
			<div>
				<?php echo $this->Form->create('Message'); ?>
				<div hidden>
					<?php echo $this->Form->input('recipient', array('id' => 'recipient-id')); ?>
				</div>
				<div class="d-flex justify-content-center mt-3">
					<label class="mr-5 message-recipient-label">Recipient</label>
					<input type="text" required name="recipient_name" id="search-recipient" class="form-control" placeholder="Search recipient name ...">
				</div>
				<?php echo $this->Form->input('content', array(
						'id' => 'message-content',
						'label' => array(
							'text' => 'Message',
							'class' => 'mr-5',
						),
						'div' => array(
							'class' => 'd-flex justify-content-center mt-3'
						),
						'rows' => '5',
						'class' => 'form-control',
					));
				?>
				<?php echo $this->Form->submit('Send Message', array(
						'class' => 'btn btn-block btn-success',
						'style' => 'width: 150px; margin-left: 118px; margin-top: 20px'
					));
				?>
				<?php echo $this->Form->end();?>
			</div>
		</div>
	</div>
</div>

<script>
	const users = <?php echo json_encode($users); ?>;
	$(document).ready(function() {
		const availableUsers = [];
		users.forEach((user) => {
			availableUsers.push({
			id: user.User.id,
			label: user.User.name,
			photo_url: user.User.photo_url 
				? '/messageboard/' + user.User.photo_url 
				: 'https://cdn-icons-png.flaticon.com/512/147/147142.png',
			})
		})
		$("#search-recipient").autocomplete({
			source: availableUsers,
			minLength: 1,
			select: function(event, ui) {
				$('#recipient-id').val(ui.item.id);
			},
			focus: function (event, ui) {
				event.preventDefault();
			},
			open: function (event, ui) {

			}
		}).data('ui-autocomplete')._renderItem = function (ul, item) {
			return $('<li>')
				.append('<div class="d-block text-decoration-none"><img style="width: 60px; max-height: 60px; margin-right: 5px" src="' + item.photo_url + '"/><span>' + item.label + '</span></div>')
				.appendTo(ul);
		};
	});

</script>