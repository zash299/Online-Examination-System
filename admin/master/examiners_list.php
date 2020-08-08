<?php include('header.php'); ?>

<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col">
				<h3 class="panel-title">List of registered examiners</h3>
			</div>
		</div>
	</div>
	<div class="card-body">
		<span id="message_operation"></span>
		<div class="table-responsive">
			<table class="table table-bordered table-striped table-hover" id="examiner_data_table">
				<thead>
					<tr>
						<th>Examiner email address</th>
						<th>Email Verified</th>
						<th>Action</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

<div class="modal" id="detailModal">
  	<div class="modal-dialog">
    	<div class="modal-content">

      		<!-- Modal Header -->
      		<div class="modal-header">
        		<h4 class="modal-title">User Details</h4>
      		</div>

      		<!-- Modal body -->
      		<div class="modal-body" id="user_details">
        		
      		</div>

      		<!-- Modal footer -->
      		<div class="modal-footer">
        		<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      		</div>
    	</div>
  	</div>
</div>
<?php include('footer.php'); ?>

<script>
$(document).ready(function(){
	
	var dataTable = $('#examiner_data_table').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"../ajax_action.php",
			type:"POST",
			data:{action:'fetch', page:'examiners_list'}
		},
		"columnDefs":[
			{
				"targets":[0,2],
				"orderable":false,
			},
		],
	});

	$(document).on('click', '.details', function(){
		var user_id = $(this).attr('id');
		$.ajax({
	      	url:"../ajax_action.php",
	      	method:"POST",
	      	data:{action:'fetch_data', user_id:user_id, page:'examiners_list'},
	      	success:function(data)
	      	{
	        	$('#user_details').html(data);
	        	$('#detailModal').modal('show');
	      	}
	    });
	});
});
</script>