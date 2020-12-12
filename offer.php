<a id="classes"></a>
<?php
	$sql = 'SELECT `class_id`, `class_name`, `class_description`, `class_img`
			FROM `classes`
			ORDER BY `class_name`';
	$result = mysqli_query($link, $sql);
	if (mysqli_num_rows($result) > 0) {
		while ($class = @mysqli_fetch_array($result)) {
			echo '<div class="row">
					<div class="col-md-12 col-lg-8 offset-lg-2">
						<a id="class_'. $class['class_id'] .'"></a>
						<div class="card mt-3 mb-3 text-center">
							<img class="card-img-top" src="'.$class['class_img'].'" alt="'.$class['class_name'].' img">
							<div class="card-body">
								<h5 class="card-title text-uppercase">'.$class['class_name'].'</h5>
								<p class="card-text">'.$class['class_description'].'</p>
							</div>
						</div>
					</div>
				</div>';
		}
	} else {
		echo '<div class="row">
					<div class="col-md-12 col-lg-8 offset-lg-2">
						<a id="#"></a>
						<div class="card mt-3 mb-3 text-center">
							<img class="card-img-top" src="" alt="NO CLASS AVIABLE img">
							<div class="card-body">
								<h5 class="card-title">NO CLASSES AVIABLE</h5>
								<p class="card-text">NO CLASSES AVIABLE</p>
							</div>
						</div>
					</div>
				</div>';
	}	
?>
