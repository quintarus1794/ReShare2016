<?php require "checkLogin.php" ?>

<html>
 <head>
  <title>ReShare: Sell/Lend</title>
  <link rel="stylesheet" href="CSS/main.css" type="text/css">
 </head>
 <body>
 <?php require 'header.php'?> 
 
	<div id="body_wrapper">
		<h2>Recent Listings</h2>
		
		
		<table id="MainContent_AvailableListings">
			<tr>
			<th>Cover</th><th>Title</th><th>ISBN</th><th>Buy/Borrow</th><th>Price</th><th>Seller</th>
			</tr>
			
			
			<?php
				/*
				require 'database.php';
				
				foreach($books as $book) {
					echo "<tr>";
					echo "<td><img src=\"\" /></td><td>".$book->title."</td><td>"$book->isbn."</td><td>".$book->buyBorrow."</td><td>".$book->seller."</td>";
					echo "</tr>";
				}
				*/
			?>

		
		</table>
		
	</div>
	
 </body>
</html>