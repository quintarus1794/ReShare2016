<html>
 <head>
	<title>ReShare</title>
	<link rel="stylesheet" href="CSS/main.css" type="text/css">
 </head>
 
 <body>
	<?php require 'header.php'?> 
	
	<div id="body_wrapper">
		<h2>Recent Listings</h2>
		
		
		<?php
			require 'database.php';
			
			$db = new ReShareDB();
			$books = $db->getTen();
			
			echo "<table id=\"MainContent_AvailableListings\">";
			echo "<tr>";
			echo "<th>Cover</th><th>Title</th><th>ISBN</th><th>Buy/Borrow</th><th>Price</th><th>Seller</th>";
			echo "</tr>";
				
			foreach($books as $book) {
				if($book->buyBorrow == 1) {
					
					$buyBorrow = "Buy";
					$price = $book->price;
					
				}else {
					
					$buyBorrow = "Borrow";
					$price = "N/A";
					
				}
				
				$img = $db->getImage($book->isbn);
				
				echo "<tr>";
				echo "<td><img src=\"".$img."\" /></td><td>".$book->title."</td><td>".$book->isbn."</td><td>".$buyBorrow."</td><td>$".$price."</td><td>".$book->seller."</td>";
				echo "</tr>";
			}
				
			echo "</table>";
		?>

		
		</table>
		
	</div>
	
 </body>
</html>