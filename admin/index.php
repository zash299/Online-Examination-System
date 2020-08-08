<?php 
	include_once('../Functions.php');

	$exam=new Functions;
	if(isset($_SESSION['admin_id']))
	{
		$admin_type = $exam->get_admin_type($_SESSION['admin_id']);
		if($admin_type == 'master'){
			$exam->redirect('master/');
		}
		else{
			$exam->redirect('sub_master/');
		}
	}
	else
	{
		$exam->redirect('../admin_login.php');
	}
	
?>