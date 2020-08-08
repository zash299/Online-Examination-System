<?php include_once('header.php');?>
<div class="jumbotron">
	<div class="container">
		<div class="row">
			<div class="col">
				<h3>Quick Look</h3>
			</div>
		</div>
		<div class="row mt-2">
			<div class="col-md-8">
				<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
				  <ol class="carousel-indicators">
				    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
				    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
				    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
				  </ol>
				  <div class="carousel-inner">
				    <div class="carousel-item active">
				      <img class="d-block w-100" src="../assets/img/user/enroll_exam.png" alt="First slide">
				    </div>
				    <div class="carousel-item">
				      <img class="d-block w-100" src="../assets/img/user/profile.png" alt="Second slide">
				    </div>
				    <div class="carousel-item">
				      <img class="d-block w-100" src="../assets/img/user/settings.png" alt="Third slide">
				    </div>
				    <div class="carousel-item">
				      <img class="d-block w-100" src="../assets/img/user/enrolled_exam.png" alt="Third slide">
				    </div>
				    <div class="carousel-item">
				      <img class="d-block w-100" src="../assets/img/user/examination_start.png" alt="Third slide">
				    </div>
				    <div class="carousel-item">
				      <img class="d-block w-100" src="../assets/img/user/examination_over.png" alt="Third slide">
				    </div>
				    <div class="carousel-item">
				      <img class="d-block w-100" src="../assets/img/user/result.png" alt="Third slide">
				    </div>
				  </div>
				  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
				    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
				    <span class="sr-only">Previous</span>
				  </a>
				  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
				    <span class="carousel-control-next-icon" aria-hidden="true"></span>
				    <span class="sr-only">Next</span>
				  </a>
				</div>
			</div>
			<div class="col-md-4">
				<div class="row">
					<div class="col-md-12">
						<a href="enroll_exam.php" class="btn btn-outline-primary mb-2">Enroll In To Exam</a>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<a href="profile.php" class="btn btn-outline-primary mb-2">Visit Profile</a>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<a href="settings.php" class="btn btn-outline-primary mb-2">Change Password</a>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<a href="enrolled_exam.php" class="btn btn-outline-primary mb-2">View Enrolled Exams</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include_once('footer.php'); ?>