<a id = 'schedule'> </a>
	<div class="row h-25 my-3 parallax-3 text-center">
		<div class=" col-md-12 col-lg-8 offset-lg-2 ">
			<div class="parallax-text top-30">

				<h1>TIMETABLE</h1>

			</div>
		</div>
	</div>

<div class="row ">
	<div class='col-10 col-lg-8 offset-lg-2 offset-1'>
		<table class="table table-responsive-md table-hover">
			<thead>
				<tr>
					<th scope="col">time</th>
					<?php
						$day_id_arr = [];
						$day_sql = 'SELECT `day_id`, `day_name`, `day_corr_num`
								FROM `days`
								ORDER BY `day_corr_num`';
						$day_result = mysqli_query($link, $day_sql);
						if (mysqli_num_rows($day_result) > 0) {
							$j=1;
							while ($day = @mysqli_fetch_array($day_result)) {
								echo '<th scope="col">'.$day['day_name'].'</th>';
								$day_id_arr[$day['day_corr_num']] = $day['day_id'];
								$j++;								
							}
						}
					?>
				</tr>
			</thead>
			<tbody>
				<?php				
					$hour_sql = 'SELECT `hour_id`,`hour_range`
							FROM `hours`
							ORDER BY `hour_range`';
					$hour_result = mysqli_query($link, $hour_sql);				
					
				
						if (mysqli_num_rows($hour_result) > 0) {
							while ($hour = @mysqli_fetch_array($hour_result)) {
								echo '<tr><th scope="row">'.$hour['hour_range'].'</th>';
										for($i=1;$i<$j;$i++){											
											$timetable_sql = 'SELECT `class_id`
															  FROM `timetable`
															  WHERE `hour_id`=? AND `day_id`=?';
											
											if($timetable_stmt = mysqli_prepare($link, $timetable_sql)){
												mysqli_stmt_bind_param($timetable_stmt, "ii", $param_hour, $param_day);
												
												$param_hour = $hour["hour_id"];
												$param_day = $day_id_arr[$i];
											    
												
											
												if (mysqli_stmt_execute($timetable_stmt)){
													$timetable_result = $timetable_stmt->get_result(); // get the mysqli result
													
													if(mysqli_num_rows($timetable_result) > 0){
														echo '<td>';
														while ($timetable_row = $timetable_result->fetch_assoc()) {
								
															$class_sql = 'SELECT `class_name`
																		 FROM `classes`
																		 WHERE `class_id`=?';
															if($class_stmt = mysqli_prepare($link, $class_sql)){
																mysqli_stmt_bind_param($class_stmt, "i", $param_class);														
																$param_class = $timetable_row['class_id'];
																if(mysqli_stmt_execute($class_stmt)){
																	$class_result = $class_stmt->get_result();																	
																	
																	while($class_row = $class_result->fetch_assoc()){
																		echo $class_row['class_name'].'<br>';
																	}
																   
																}
																mysqli_stmt_close($class_stmt);
															}
														
														}
														echo '</td>';
													}
													else{
														echo '<td> </td>';
													}
											}
											mysqli_stmt_close($timetable_stmt);
											}
										}
								echo '</tr>';
							}
						}
				?>
			</tbody>
		</table>
	</div>
</div>