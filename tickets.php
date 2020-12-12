<a id = 'prices'> </a>
<div class="row h-25 mb-3 parallax-2 text-center">
	<div class=" col-md-12 col-lg-8 offset-lg-2 ">
		<div class="parallax-text top-30">

			<h1>PRICES</h1>

		</div>
	</div>
</div>


			
<?php
	$sql = 'SELECT `ticket_id`, `ticket_name`, `ticket_description`, `ticket_price`, `ticket_img` 
			FROM `tickets`';
	$result = mysqli_query($link, $sql);
	if (mysqli_num_rows($result) > 0) {
		echo '<div class="row justify-content">
				<div class="col-lg-8 offset-lg-2 col-10 offset-1">
					<div class="card-columns text-center">';
		while ($ticket = @mysqli_fetch_array($result)) {
			echo '<div class="card" >
					<img class="card-img-top" src="'.$ticket['ticket_img'].'" alt="'.$ticket['ticket_name'].' img">
					<div class="card-body">
						<h5 class="card-title text-uppercase">'.$ticket['ticket_name'].'</h5>
						<hr class="underline">
						<h5 class="card-title">'.$ticket['ticket_price'].' $</h5>
						<hr class="underline">
						<p class="card-text">'.$ticket['ticket_description'].'</p>
						<a href="add_ticket.php?id='.$ticket['ticket_id'].'" class="btn btn-primary">Buy it now</a>
					</div>
				</div>';
		}
		echo '		</div>
				</div>	
			</div>';
	} else {
		echo '<p class="text-center">NO TICKETS AVIABLE</p>';
	}
?>