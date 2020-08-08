<?php
include_once('Functions.php');
$exam=new Functions;

if(isset($_SESSION['admin_id']))
{
  $exam->redirect('admin/');
}

include_once('header.php'); 
?>
<br><br>
<div class="container">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
    		<span id="message"></span>
  			<div class="card">
    			<div class="card-header text-center bg-danger text-light">Admin Sign up</div>
    			<div class="card-body">
      				<form method="post" id="admin_register_form">
		                <div class="form-group">
		                    <label>Enter Email Address</label>
		                    <input type="text" name="admin_email_address" id="admin_email_address" class="form-control" data-parsley-checkemail data-parsley-checkemail-message='Email Address already Exists' />
		                </div>
		                <div class="form-group">
		                  <label>Enter Password</label>
		                  <input type="password" name="admin_password" id="admin_password" class="form-control" />
		                </div>
		                <div class="form-group">
		                  <label>Enter Confirm Password</label>
		                  <input type="password" name="confirm_admin_password" id="confirm_admin_password" class="form-control" />
		                </div>
		                <div class="form-group">
		                  <input type="hidden" name="page" value="register" />
		                  <input type="hidden" name="action" value="register" />
		                </div>
		                <div class="form-group">
		                	<input type="submit" name="admin_register" id="admin_register" class="btn btn-outline-danger" value="Sign up" />
		                </div>
              		</form>
      				<div align="center">
      					<a href="admin_login.php" class="text-danger">Have an account ?</a>
      				</div>
    			</div>
  			</div>
		</div>
		<div class="col-md-3"></div>
	</div>
</div>

<?php include_once('footer.php') ?>
<script>
//Using parsley javascript library for validation
$(document).ready(function(){
  //Custom validator for email check
	window.ParsleyValidator.addValidator('checkemail', {
    validateString: function(value)
    {
      return $.ajax({
        url:"admin/ajax_action.php",
        method:"POST",
        data:{page:'register', action:'check_email', email:value},
        dataType:"json",
        async: false,
        success:function(data)
        {
          return true;
        }
      });
    }
  });

  $('#admin_register_form').parsley();

  $('#admin_register_form').on('submit', function(event){

    event.preventDefault();
    /*for adding required attribute*/
    $('#admin_email_address').attr('required', 'required');
    /*for correct email format*/
    $('#admin_email_address').attr('data-parsley-type', 'email');
    /*for required password*/
    $('#admin_password').attr('required', 'required');

    $('#confirm_admin_password').attr('required', 'required');

    $('#confirm_admin_password').attr('data-parsley-equalto', '#admin_password');

    if($('#admin_register_form').parsley().isValid())
    {
      $.ajax({
        url:"admin/ajax_action.php",
        method:"POST",
        data:$(this).serialize(), /*converts form data into url converted strings*/
        dataType:"json",
        beforeSend:function(){
          $('#admin_register').attr('disabled', 'disabled');
          $('#admin_register').val('please wait...');
        },
        success:function(data)
        {
          if(data.success)
          {
            $('#message').html('<div class="alert alert-success">Please check your email</div>');
            $('#admin_register_form')[0].reset();
            $('#admin_register_form').parsley().reset();
          }

          $('#admin_register').attr('disabled', false);
          $('#admin_register').val('Sign up');
        }
      });
    }
  });
});

</script>
