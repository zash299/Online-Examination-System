<?php
include('Functions.php');
$exam = new Functions;
$exam->user_session_public();

include_once('header.php'); 
?>
<br><br>
<div class="container">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
      <span id="message">
        <?php
          if(isset($_GET['verified'])){
            echo "
              <div class='alert alert-success'>Your email has been verified, now you can login.</div>
            "; 
          }
        ?>
      </span>
			<div class="card">
  				<div class="card-header text-center bg-primary text-light">User Sign in</div>
  				<div class="card-body">
				    <form method="post" id="user_login_form">
				      <div class="form-group">
				        <label>Enter Email Address</label>
				          <input type="text" name="user_email_address" id="user_email_address" class="form-control" />
				        </div>
				      <div class="form-group">
				        <label>Enter Password</label>
				        <input type="password" name="user_password" id="user_password" class="form-control" />
				      </div>
				      <div class="form-group">
				        <input type="hidden" name="page" value="login" />
				        <input type="hidden" name="action" value="login" />
				      </div>
				      <div class="form-group">
				      	<input type="submit" name="user_login" id="user_login" class="btn btn-outline-primary" value="Sign in" />
				      </div>
				    </form>
				    <div align="center">
				      <a href="user_register.php">Create an account</a>
				    </div>
  				</div>
			</div>
		</div>
		<div class="col-md-3"></div>
	</div>
</div>
<?php include_once('footer.php') ?>
<script>
$(document).ready(function(){

  $('#user_login_form').parsley();

  $('#user_login_form').on('submit', function(event){
    event.preventDefault();

    $('#user_email_address').attr('required', 'required');

    $('#user_email_address').attr('data-parsley-type', 'email');

    $('#user_password').attr('required', 'required');

    if($('#user_login_form').parsley().validate())
    {
      $.ajax({
        url:"user/ajax_action.php",
        method:"POST",
        data:$(this).serialize(),
        dataType:"json",
        beforeSend:function()
        {
          $('#user_login').attr('disabled', 'disabled');
          $('#user_login').val('please wait...');
        },
        success:function(data)
        {
          if(data.success)
          {
            location.href='user/';
          }
          else
          {
            $('#message').html('<div class="alert alert-danger">'+data.error+'</div>');
          }

          $('#user_login').attr('disabled', false);

          $('#user_login').val('Sign in');
        }
      })
    }
  });
});	
</script>
