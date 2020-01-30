<div class="panel"><a href = 'index.php?cart'>Your cart</a>
<?php 
if(!isset($_SESSION['logged_id']))
	echo "<a href = 'index.php?signin'>Sign in</a>";
else
	echo "<a href = 'index.php?logout'>Log out</a>";
if(isset($_SESSION['logged_login']))
	echo "<div style=\"float: right;\">" . $_SESSION['logged_login'] . "</div>";
?>
</div>