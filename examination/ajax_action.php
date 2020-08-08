<?php

//user_ajax_action.php

include('../Functions.php');
$exam = new Functions;
date_default_timezone_set("Asia/Kolkata");
$current_datetime = date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')));

if(isset($_POST['page']))
{
	if($_POST['page'] == 'examination')
	{
		if($_POST['action'] == 'load_question')
		{
			if($_POST['question_id'] == '')
			{
				$exam->query = "
				SELECT * FROM question_table 
				WHERE online_exam_id = '".$_POST["exam_id"]."' 
				ORDER BY question_id ASC 
				LIMIT 1
				";
			}
			else
			{
				$exam->query = "
				SELECT * FROM question_table 
				WHERE question_id = '".$_POST["question_id"]."' 
				";
			}

			$result = $exam->query_result();

			$output = '';

			foreach($result as $row)
			{
				$output .= '
				<h5>'.$row["question_title"].'</h5>
				<hr />
				<div class="row">
				';

				$exam->query = "
				SELECT * FROM option_table 
				WHERE question_id = '".$row['question_id']."'
				";
				$sub_result = $exam->query_result();

				$count = 1;

 				foreach($sub_result as $sub_row)
				{
					$exam->query = "
					SELECT * FROM user_exam_question_answer 
					WHERE question_id = '".$row['question_id']."'
					";
					$answer_result = $exam->query_result();
					foreach($answer_result as $row)
					{
						$user_answer_option = $row["user_answer_option"];	
					}
					$output .= '
					<div class="col-md-6">
						<div class="radio">
							<label><h4><input type="radio" name="option_1" class="answer_option"';
							if($count == $user_answer_option){
								$output .= ' checked="checked" ';
							}

					$output .= '
							data-question_id="'.$row["question_id"].'" data-id="'.$count.'"/>&nbsp;'.$sub_row["option_title"].'</h4></label>
						</div>
					</div>
					';
					$count = $count + 1;
				}

				$output .= '</div>';

				$exam->query = "
				SELECT question_id FROM question_table 
				WHERE question_id < '".$row['question_id']."' 
				AND online_exam_id = '".$_POST["exam_id"]."' 
				ORDER BY question_id DESC 
				LIMIT 1";

				$previous_result = $exam->query_result();

				$previous_id = '';
				$next_id = '';

				foreach($previous_result as $previous_row)
				{
					$previous_id = $previous_row['question_id'];
				}

				$exam->query = "
				SELECT question_id FROM question_table 
				WHERE question_id > '".$row['question_id']."' 
				AND online_exam_id = '".$_POST["exam_id"]."' 
				ORDER BY question_id ASC 
				LIMIT 1";
  				
  				$next_result = $exam->query_result();

  				foreach($next_result as $next_row)
				{
					$next_id = $next_row['question_id'];
				}

				$if_previous_disable = '';
				$if_next_disable = '';

				if($previous_id == "")
				{
					$if_previous_disable = 'disabled';
				}
				
				if($next_id == "")
				{
					$if_next_disable = 'disabled';
				}

				$output .= '
				  	<div align="right">
				   		<button type="button" name="previous" class="btn btn-info previous" id="'.$previous_id.'" '.$if_previous_disable.'>Previous</button>
				   		<button type="button" name="next" class="btn btn-warning  next" id="'.$next_id.'" '.$if_next_disable.'>Next</button>
				  	</div>
				  	';
			}

			echo $output;
		}

		if($_POST['action'] == 'question_navigation')
		{
			$exam->query = "
				SELECT question_id FROM question_table 
				WHERE online_exam_id = '".$_POST["exam_id"]."' 
				ORDER BY question_id ASC 
				";
			$result = $exam->query_result();
			$output = '
			<div class="card">
				<div class="card-header">Question Navigation</div>
				<div class="card-body">
					<div class="row">
			';
			$count = 1;
			foreach($result as $row)	
			{
				$output .= '
				<div class="col">
					<button type="button" class="btn btn-danger rounded-circle btn-lg question_navigation" data-question_id="'.$row["question_id"].'">'.$count.'</button>
				</div>
				';
				$count++;
			}
			$output .= '
				</div>
			</div></div>
			';
			echo $output;
		}

		if($_POST['action'] == 'user_detail')
		{
			$exam->query = "
			SELECT * FROM user_table 
			WHERE user_id = '".$_SESSION["user_id"]."'
			";

			$result = $exam->query_result();

			$output = '
			<div class="card">
				
				<div class="card-body">
					<div class="row">
			';

			foreach($result as $row)
			{
				$output .= '
				<div class="col-md-3">
					<img src="../upload/'.$row["user_image"].'" class="img-fluid" />
				</div>
				<div class="col-md-9">
					<p>Name : '.$row["user_name"].'</p>
					<p>Email ID : '.$row["user_email_address"].'</p>
					<p>Gender : '.$row["user_gender"].'</p>
				</div>
				';
			}
			$output .= '</div></div></div>';
			echo $output;
		}

		if($_POST['action'] == 'answer')
		{
			$exam_right_answer_mark = $exam->Get_question_right_answer_mark($_POST['exam_id']);
			$exam_wrong_answer_mark = $exam->Get_question_wrong_answer_mark($_POST['exam_id']);
			$orignal_answer = $exam->Get_question_answer_option($_POST['question_id']);

			$marks = 0;

			if($orignal_answer == $_POST['answer_option'])
			{
				$marks = '+' . $exam_right_answer_mark;
			}
			else
			{
				$marks = '-' . $exam_wrong_answer_mark;
			}

			$exam->data = array(
				':user_answer_option'	=>	$_POST['answer_option'],
				':marks'				=>	$marks,
			);

			$exam->query = "
			UPDATE user_exam_question_answer 
			SET user_answer_option = :user_answer_option, marks = :marks 
			WHERE user_id = '".$_SESSION["user_id"]."' 
			AND exam_id = '".$_POST['exam_id']."' 
			AND question_id = '".$_POST["question_id"]."'
			";
			$exam->execute_query();
		}
	}

}
?>