<?php include('header.php'); ?>
<!----------------------------------->
<?php 

$exam_id = '';
$exam_status = '';
$remaining_minutes = '';
date_default_timezone_set("Asia/Kolkata");

if(isset($_GET['code']))
{
	$exam_id = $exam->Get_exam_id($_GET["code"]);
	$exam->query = "
	SELECT online_exam_status, online_exam_datetime, online_exam_duration FROM online_exam_table 
	WHERE online_exam_id = '$exam_id'
	";

	$result = $exam->query_result();

	foreach($result as $row)
	{
		$exam_status = $row['online_exam_status'];
		$exam_star_time = $row['online_exam_datetime'];
		$duration = $row['online_exam_duration'] . ' minute';
		$exam_end_time = strtotime($exam_star_time . '+' . $duration);

		$exam_end_time = date('Y-m-d H:i:s', $exam_end_time);
		$remaining_minutes = strtotime($exam_end_time) - time();
	}
}
else
{
	header('location:../user');
}

?>
<!--------------------------------------->
<?php
if($exam_status == 'Started'){
	$exam->data = array(
		':user_id'		=>	$_SESSION['user_id'],
		':exam_id'		=>	$exam_id,
		':attendance_status'	=>	'Present'
	);

	$exam->query = "
	UPDATE user_exam_enroll_table 
	SET attendance_status = :attendance_status 
	WHERE user_id = :user_id 
	AND exam_id = :exam_id
	";

	$exam->execute_query();
?>
<br>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-8">
			<div class="card" style="height:550px;">
				<div class="card-header">Examination</div>
				<div class="card-body">
					<div id="single_question_area"></div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="row">
				<div class="col-md-12" align="center">
					<div id="exam_timer" data-timer="<?php echo $remaining_minutes; ?>" style="max-width:300px; width: 100%;">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div id="user_details_area"></div>
				</div>
			</div>
			<div class="row mt-3">
				<div class="col-md-12">
					<div id="question_navigation_area"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php } ?>
<!-------------------------------------------->
<?php

if($exam_status == 'Completed')
{
	$exam->query = "
	SELECT * FROM question_table 
	INNER JOIN user_exam_question_answer 
	ON user_exam_question_answer.question_id = question_table.question_id 
	WHERE question_table.online_exam_id = '$exam_id' 
	AND user_exam_question_answer.user_id = '".$_SESSION["user_id"]."'
	";

	$result = $exam->query_result();
?>
	<div class="card">
		<div class="card-header">
			<div class="row">
				<div class="col-md-8"><h3>Exam Result</h3></div>
			</div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<tr>
						<th>Question</th>
						<th>Option 1</th>
						<th>Option 2</th>
						<th>Option 3</th>
						<th>Option 4</th>
						<th>Your Answer</th>
						<th>Answer</th>
						<th>Result</th>
						<th>Marks</th>
					</tr>
					<?php
					$total_mark = 0;

					foreach($result as $row)
					{
						$exam->query = "
						SELECT * 
						FROM option_table 
						WHERE question_id = '".$row["question_id"]."'
						";

						$sub_result = $exam->query_result();
						$user_answer = '';
						$orignal_answer = '';
						$question_result = '';

						if($row['marks'] == '0')
						{
							$question_result = '<h4 class="badge badge-dark">Not Answered</h4>';
						}

						if($row['marks'] > '0')
						{
							$question_result = '<h4 class="badge badge-success">Correct</h4>';
						}

						if($row['marks'] < '0')
						{
							$question_result = '<h4 class="badge badge-danger">Wrong</h4>';
						}

						echo '
						<tr>
							<td>'.$row['question_title'].'</td>
						';

						foreach($sub_result as $sub_row)
						{
							echo '<td>'.$sub_row["option_title"].'</td>';

							if($sub_row["option_number"] == $row['user_answer_option'])
							{
								$user_answer = $sub_row['option_title'];
							}

							if($sub_row['option_number'] == $row['answer_option'])
							{
								$orignal_answer = $sub_row['option_title'];
							}
						}
						echo '
						<td>'.$user_answer.'</td>
						<td>'.$orignal_answer.'</td>
						<td>'.$question_result.'</td>
						<td>'.$row["marks"].'</td>
					</tr>
						';
					}

					$exam->query = "
					SELECT SUM(marks) as total_mark FROM user_exam_question_answer 
					WHERE user_id = '".$_SESSION['user_id']."' 
					AND exam_id = '".$exam_id."'
					";

					$marks_result = $exam->query_result();

					foreach($marks_result as $row)
					{
					?>
					<tr>
						<td colspan="8" align="right">Total Marks</td>
						<td align="right"><?php echo $row["total_mark"]; ?></td>
					</tr>
					<?php	
					}

					?>
				</table>
			</div>
		</div>
	</div>
<?php } ?>

<!--------------------------------------->
<?php include('footer.php'); ?>

<script>

$(document).ready(function(){
	var exam_id = "<?php echo $exam_id; ?>";

	load_question();
	question_navigation();
	load_user_details();

	function load_question(question_id = '')
	{
		$.ajax({
			url:"ajax_action.php",
			method:"POST",
			data:{exam_id:exam_id, question_id:question_id, page:'examination', action:'load_question'},
			success:function(data)
			{
				$('#single_question_area').html(data);
			}
		})
	}

	$(document).on('click', '.next', function(){
		var question_id = $(this).attr('id');
		load_question(question_id);
	});

	$(document).on('click', '.previous', function(){
		var question_id = $(this).attr('id');
		load_question(question_id);
	});

	function question_navigation()
	{
		$.ajax({
			url:"ajax_action.php",
			method:"POST",
			data:{exam_id:exam_id, page:'examination', action:'question_navigation'},
			success:function(data)
			{
				$('#question_navigation_area').html(data);
			}
		})
	}

	$(document).on('click', '.question_navigation', function(){
		var question_id = $(this).data('question_id');
		load_question(question_id);
	});

	$("#exam_timer").TimeCircles({ 
		time:{
			Days:{
				show: false
			},
			Hours:{
				show: true
			}
		}
	});

	setInterval(function(){
		var remaining_second = $("#exam_timer").TimeCircles().getTime();
		if(remaining_second < 1)
		{
			alert('Exam time over');
			window.location.replace = "http://localhost/online_exam/user/enrolled_exam.php";
		}
	}, 1000);

	function load_user_details()
	{
		$.ajax({
			url:"ajax_action.php",
			method:"POST",
			data:{page:'examination', action:'user_detail'},
			success:function(data)
			{
				$('#user_details_area').html(data);
			}
		})
	}

	$(document).on('click', '.answer_option', function(){
		var question_id = $(this).data('question_id');

		var answer_option = $(this).data('id');

		$.ajax({
			url:"ajax_action.php",
			method:"POST",
			data:{question_id:question_id, answer_option:answer_option, exam_id:exam_id, page:'examination', action:'answer'},
			success:function(data)
			{

			}
		})
	});

});
</script>