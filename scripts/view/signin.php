<?php
include 'head.html';
?>
<div class="container">
<form method="POST" action="">
	<label>Login</label><br><input type="text" name="login"></input><br>
	<label>Password</label><br><input type="password" name="password"></input><br>	
	<input type="hidden" name="operation" value="signin"></input>
	<input type="submit" value="Sign in" class="button"></input>
</form>

<div class="alert" id="alert">
<?php
if(isset($_SESSION['notLogged']) && $_SESSION['notLogged']==true)
{
	echo "<script> 
					alert(\"You have to be logged to buy things\");
		 </script>";
    unset($_SESSION['notLogged']);
}
if(isset($_SESSION['bad_attempt']) && $_SESSION['bad_attempt']==true)
{
	echo "<script> 
			document.getElementById(\"alert\").style.backgroundColor = \"red\" ;
		 </script> ";
	echo "Login or password is incorrect";
	unset($_SESSION['bad_attempt']);
}
?>
</div>
</div>