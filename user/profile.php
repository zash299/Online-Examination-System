<?php include('header.php'); ?>

<?php
	$exam->query = "
		SELECT * FROM user_table 
		WHERE user_id = '".$_SESSION['user_id']."'
	";
	$result = $exam->query_result();
?>

<br><br>
<div class="container">
	<h3>Your Profile</h3><br>
	<form method="post" id="profile_form">
		<?php foreach($result as $row){ ?>
			<div class="row">
				<div class="col-md-6">
					<div class="row">
						<div class="col">
							<div class="form-group">
					       		<label>User Name</label>
					        	<input type="text" name="user_name" id="user_name" class="form-control" value="<?php echo $row["user_name"]; ?>" />
					    	</div>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="form-group">
								<label>User Email Address</label>
								<input type="email" name="user_email_address" id="user_email_address" class="form-control" value="<?php echo $row["user_email_address"];?>" readonly/>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col">
						    <div class="form-group">
						        <label>User Gender</label>
						        <select name="user_gender" id="user_gender" class="form-control">
						          	<option value="Male">Male</option>
						          	<option value="Female">Female</option>
						        </select>
						    </div>								
						</div>
					</div>
					<div class="row">
						<div class="col">
					    	<div class="form-group">
					        	<label>User Mobile Number</label>
					        	<input type="text" name="user_mobile_no" id="user_mobile_no" class="form-control" value="<?php echo $row["user_mobile_no"]; ?>" />
					    	</div>							
						</div>
					</div>
					<div class="row">
						<div class="col">
						    <div class="form-group">
						        <label>User Address</label>
						        <textarea name="user_address" id="user_address" class="form-control"><?php echo $row["user_address"]; ?></textarea>
						    </div>							
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="row">
						<div class="col">
						    <div class="form-group">
						        <label>User Profile Picture</label>
						        <input type="file" name="user_image" id="user_image" accept="image/*" /><br />
						        <img src="../upload/<?php echo $row["user_image"]; ?>" class="img-thumbnail" width="250"  />
						        <input type="hidden" name="hidden_user_image" value="<?php echo $row["user_image"]; ?>" />
						    </div>								
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
				        <input type="hidden" name="page" value="profile" />
				        <input type="hidden" name="action" value="profile" />
				        <input type="submit" name="user_profile" id="user_profile" class="btn btn-outline-primary" value="Save Profile" />
					</div>
				</div>
			</div>
		<?php } ?>
	</form>
</div>
<?php include('footer.php')?>

<script>
$(document).ready(function(){
	$('#user_gender').val("<?php echo $row["user_gender"]; ?>");
	
	$('#profile_form').parsley();
	$('#profile_form').on('submit', function(event){
		event.preventDefault();
		$('#user_name').attr('required', 'required');
		$('#user_name').attr('data-parsley-pattern', '^[a-zA-Z ]+$');
		$('#user_address').attr('required', 'required');
		$('#user_mobile_no').attr('required', 'required');
		$('#user_mobile_no').attr('data-parsley-pattern', '^[0-9]+$');
		//$('#user_image').attr('required', 'required');
		$('#user_image').attr('accept', 'image/*');

		if($('#profile_form').parsley().validate())
		{
			$.ajax({
				url:"ajax_action.php",
				method:"POST",
				data: new FormData(this),
				dataType:"json",
				contentType: false,
				cache: false,
				processData:false,				
				beforeSend:function()
				{
					$('#user_profile').attr('disabled', 'disabled');
					$('#user_profile').val('please wait...');
				},
				success:function(data)
				{
					if(data.success)
					{
						location.reload(true);
					}
					else
					{
						$('#message').html('<div class="alert alert-danger">'+data.error+'</div>');
					}
					$('#user_profile').attr('disabled', false);
					$('#user_profile').val('Save Profile');
				}
			});
		}
	});
});
</script>