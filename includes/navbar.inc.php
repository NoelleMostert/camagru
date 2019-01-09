<div class="header">
        <a href="./index.php">InnuendO</a>
        <div class="header-right">
		<a href ="display.php">Public Gallery</a>
			<?php
			
				if (isset($_SESSION["user_name"]))
				{
					if ($_SESSION["user_name"] != "guest")
					{ 
						echo '<a href="update.php">Update Details</a>
						<a href="changepass.php">Change Password</a>
						<a href="profile.php">Profile</a>
						<a href="logout.php">Log Out</a>';
					}
				}
			?>

           
            
        </div>
</div>