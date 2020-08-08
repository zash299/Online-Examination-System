<?php include('header.php'); ?>

<br><br>
<div class="container">
	<h3>Change Password</h3>
	<form method="post" id="change_password_form">
		<div class="row">
			<div class="col-md-6">
			    <div class="form-group">
			        <label>Enter New Password</label>
			        <input type="password" name="user_password" id="user_password" class="form-control" />
			    </div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
			        <label>Re-enter New Password</label>
			        <input type="password" name="confirm_user_password" id="confirm_user_password" class="form-control" />
				</div>				
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<input type="hidden" name="page" value="settings" />
		    	<input type="hidden" name="action" value="settings" />
		    	<input type="submit" name="user_password" id="user_password" class="btn btn-outline-primary" value="Change Password" />
			</div>
		</div>
	</form>
</div>

<?php include('footer.php') ?>
<script>

$(document).ready(function(){

	$('#change_password_form').parsley();

	$('#change_password_form').on('submit', function(event){
		event.preventDefault();

		$('#user_password').attr('required', 'required');

		$('#confirm_user_password').attr('required', 'required');

		$('#confirm_user_password').attr('data-parsley-equalto', '#user_password');

		if($('#change_password_form').parsley().validate())
		{
			$.ajax({
				url:"ajax_action.php",
				method:"POST",
				data:$(this).serialize(),
				dataType:"json",
				beforeSend:function()
				{
					$('#change_password').attr('disabled', 'disabled');
					$('#change_password').val('please wait...');
				},
				success:function(data)
				{
					if(data.success)
					{
						alert(data.success);
						location.reload(true);
					}
					$('#change_password').attr('disabled', false);
					$('#change_password').val('Change Password');
				}
			})
		}
	});
	
});

</script>