<?php
include('header.php');
$exam->Change_exam_status($_SESSION['user_id']);
?>


<div class="card">
	<div class="card-header"><h3>Enrolled Exam List</h3></div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered table-striped table-hover" id="exam_data_table">
				<thead>
					<tr>
						<th>Exam Title</th>
						<th>Date & Time</th>
						<th>Duration</th>
						<th>Total Question</th>
						<th>Right Answer Mark</th>
						<th>Wrong Answer Mark</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

<?php include('footer.php') ?>

<script>
$(document).ready(function(){

	var dataTable = $('#exam_data_table').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"ajax_action.php",
			type:"POST",
			data:{action:'fetch', page:'enrolled_exam'}
		},
		"columnDefs":[
			{
				"targets":[7],
				"orderable":false,
			},
		],
	});

});

</script>