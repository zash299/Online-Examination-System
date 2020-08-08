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
        	<span id="message">
	          	<?php
		          	if(isset($_GET['verified'])){
			            echo '
			            <div class="alert alert-success">
			              Your email has been verified, now you can login
			            </div>
			            ';
			         }
	          	?>
          	</span>
        	<div class="card">
            <div class="card-header text-center bg-danger text-light">Admin Sign in</div>
            <div class="card-body">
            	<form method="post" id="admin_login_form">
                	<div class="form-group">
                  		<label>Enter Email Address</label>
                  		<input type="text" name="admin_email_address" id="admin_email_address" class="form-control" />
                	</div>
	                <div class="form-group">
	                  <label>Enter Password</label>
	                  <input type="password" name="admin_password" id="admin_password" class="form-control" />
	                </div>
	                <div class="form-group">
	                  <input type="hidden" name="page" value="login" />
	                  <input type="hidden" name="action" value="login" />
	                </div>
	                <div class="form-group">
	                	<input type="submit" name="admin_login" id="admin_login" class="btn btn-outline-danger" value="Sign in" />
	                </div>
              	</form>
              <div align="center">
                <a href="admin_register.php" class="text-danger">Create an account</a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>

<?php include_once('footer.php'); ?>
<script>
  $(document).ready(function(){

  $('#admin_login_form').parsley();

  $('#admin_login_form').on('submit', function(event){
    event.preventDefault();

    $('#admin_email_address').attr('required', 'required');

    $('#admin_email_address').attr('data-parsley-type', 'email');

    $('#admin_password').attr('required', 'required');

    if($('#admin_login_form').parsley().validate())
    {
      $.ajax({
        url:"admin/ajax_action.php",
        method:"POST",
        data:$(this).serialize(),
        dataType:"json",
        beforeSend:function(){
          $('#admin_login').attr('disabled', 'disabled');
          $('#admin_login').val('please wait...');
        },
        success:function(data)
        {
          if(data.success)
          {
            if(data.type == 'sub_master'){
              location.href= "admin/sub_master/";
            }
            else{     //master
              location.href = "admin/master";
            }
          }
          else
          {
            $('#message').html('<div class="alert alert-danger">'+data.error+'</div>');
          }
          $('#admin_login').attr('disabled', false);
          $('#admin_login').val('Sign in');
        }
      });
    }
  });
});
</script>
