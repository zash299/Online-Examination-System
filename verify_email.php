<?php

//verify_email.php

include('Functions.php');

$exam = new Functions;

if(isset($_GET['type'], $_GET['code']))
{
	if($_GET['type'] == 'admin')
	{
		$exam->data = array(
			':email_verified'		=>	'yes'
		);

		$exam->query = "
		UPDATE admin_table 
		SET email_verified = :email_verified 
		WHERE admin_verfication_code = '".$_GET['code']."'
		";

		$exam->execute_query();

		$exam->redirect('admin_login.php?verified=success');
	}

	if($_GET['type'] == 'user')
	{
		$exam->data = array(
			':user_email_verified'	=>	'yes'
		);

		$exam->query = "
		UPDATE user_table 
		SET user_email_verified = :user_email_verified 
		WHERE user_verfication_code = '".$_GET['code']."'
		";

		$exam->execute_query();

		$exam->redirect('user_login.php?verified=success');
	}
}
?>