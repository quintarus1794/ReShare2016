<div id="header_outer">
	<div id="header_inner">
	
		<div id="header_login">
			<ul class="header_content">
				<?php
				if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')){
					echo "<li><a href=\"login.php\">Login</a></li>";
				}else {
					echo "<li><a href=\"logout.php\">Log Out</a></li>";
				}
				?>
				<li><a href="register.php">Register</a></li>
			</ul>
		</div>
	
		<div id="header_navigation">
			<ul class="header_content">
				<li id="home_nav"><a href="index.php">ReShare</a></li>
				<li><a href="buy-borrow.php">Buy/Borrow</a></li>
				<li><a href="sell-lend.php">Sell/Lend</a></li>
			</ul>
		</div>
			
		
	</div>
</div>

