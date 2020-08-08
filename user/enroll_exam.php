<?php include('header.php'); ?>

<br><br>
<div class="container">
	<div class="row justify-content-end">
		<a class="btn btn-primary" href="enrolled_exam.php">View all enrolled exam</a>
	</div>
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<h3>Search Exam</h3>
			<form method="post" id="exam_enroll_code_form">
				<div class="row">
					<div class="col-md-8">
						<div class="form-group">
    						<input type="text" class="form-control" name="exam_enroll_code" id="exam_enroll_code" placeholder="Enter exam enrollment code">
  						</div>
					</div>
					<div class="col-md-4">
						<button class="btn btn-primary" id="exam_enroll_code_btn">Search</button>
					</div>
				</div>
			</form><br>
			<span id="exam_details"></span>
		</div>
		<div class="col-md-3"></div>		
	</div>
</div>

<?php include('footer.php'); ?>

<script>
$(document).ready(function(){

	$(document).on('click', '#exam_enroll_code_btn', function(event)
	{
		event.preventDefault();
		if($('#exam_enroll_code').parsley().validate())
		{
			enroll_code = $('#exam_enroll_code').val();
			$.ajax
			({
				url:"ajax_action.php",
				method:"POST",
				data:{action:'fetch_exam', page:'enroll_exam', enroll_code:enroll_code},
				beforeSend:function()
				{
					$('#exam_enroll_code_btn').attr('disabled', 'disabled');
					$('#exam_enroll_code_btn').text('Searching...');
				},
				success:function(data)
				{
					$('#exam_details').html(data);
					$('#exam_enroll_code_btn').attr('disabled', false);
					$('#exam_enroll_code_btn').text('Search');
				}
			});
		}

	});

	$(document).on('click', '#enroll_button', function(){
		exam_id = $('#enroll_button').data('exam_id');
		$.ajax({
			url:"ajax_action.php",
			method:"POST",
			data:{action:'enroll', page:'enroll_exam', exam_id:exam_id},
			beforeSend:function()
			{
				$('#enroll_button').attr('disabled', 'disabled');
				$('#enroll_button').text('please wait');
			},
			success:function()
			{
				$('#enroll_button').attr('disabled', true);
				$('#enroll_button').removeClass('btn-warning');
				$('#enroll_button').addClass('btn-success');
				$('#enroll_button').text('Successfully Enrolled');
			}
		});
	});
});
</script>