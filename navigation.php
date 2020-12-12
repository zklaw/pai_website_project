<nav class="navbar navbar-expand-lg fixed-top text-uppercase"> <a class="navbar-brand d-block d-lg-none" href="index.php">DANCE &amp YOGA STUDIO</a>
  <button class="navbar-toggler first-button" type="button" data-toggle="collapse" data-target="#collapsibleNavbar"
    	aria-controls="collapsibleNavbar" aria-expanded="false" aria-label="Toggle navigation">
  <div class="animated-icon1"><span></span><span></span><span></span></div>
  </button>
  <div class="collapse navbar-collapse offset-lg-2 col-lg-8" id="collapsibleNavbar">
    <ul class="navbar-nav">
      <li class="nav-item"> <a class="nav-link" href="index.php">HOME</a> </li>

	  <li class="dropdown">
		<a class="dropdown-toggle nav-link" data-toggle="dropdown" href="#">CLASSES<span class="caret"></span></a>
		  <ul class='dropdown-menu text-lg-left text-center'>
			  <?php
			  	$sql = 'SELECT `class_id`, `class_name`
						FROM `classes`
						ORDER BY `class_name`';
			  	$result = mysqli_query($link, $sql);
				if (mysqli_num_rows($result) > 0) {
					while ($class = @mysqli_fetch_array($result)) {
						echo '<li><a class="nav-link" href="index.php#class_' . $class['class_id'] . '">' . $class['class_name'] . '</a></li>' . PHP_EOL;
					}
				} else {
					echo '<li><a class="nav-link" href="#">NO CLASSES AVIABLE</a></li>';
				}
			
			  ?>
		  </ul>
	  </li>
	  <li class="nav-item"> <a class="nav-link" href="index.php#prices">PRICES</a> </li>	
      <li class="nav-item"> <a class="nav-link" href="index.php#schedule">SCHEDULE</a> </li>
	  <li class="nav-item"> <a class="nav-link" href="index.php#gallery">Gallery</a> </li>
    </ul>
    <ul class="navbar-nav navbar-login ml-auto">
		<?php
			
			if(session_status() == PHP_SESSION_NONE){
				//session has not started
				session_start();
			}
			if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
				if($_SESSION["username"]!=$admin_name){				
					echo '<li class="nav-item"> <a class="nav-link" href="welcome_user.php">my account</a> </li>';
				}
				else{
					echo '<li class="nav-item"> <a class="nav-link" href="welcome_admin.php">my account</a> </li>';
				}
				
			}
			else{
				echo '<li class="nav-item"> <a class="nav-link" href="login.php">LOG IN</a> </li>';
			}
		?>
      
    </ul>
  </div>
</nav>