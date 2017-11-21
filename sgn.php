<?php 

function clean($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
	
	$dbhost = "127.0.0.1";
	$dbport = "3306";
	$dbuser = "root";								//change to mysql username
	$dbpass = "";									//change to mysql password
	$db = "sp"; 									//change to mysql database name

	$user = "";
	$email = "";
	$pass = "";
	$cp = "";

	$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$db,$dbport);
	
	if(mysqli_connect_errno())
	{
		die("could not connect: \n". mysqli_connect_error());
	}
		
	if(empty($_POST["username"]))
	{
		echo "username is empty";
		return;
	}
	else
	{
		$user = clean($_POST["username"]);
		if (!preg_match("/^[a-zA-Z]*$/",$user)) 
		{
			echo "Only letters, white space and digits allowed";
			return;		
		}
	}
	
	if(empty($_POST["email"]))
	{
		echo "email is empty";
		return;
	}
	else
	{
		$email = clean($_POST["email"]);
		if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email)) 
		{
			echo "Invalid email";
			return;
		}
	}
	
	if(empty($_POST["password"]))
	{
		echo "please enter password";
		return;
	}
	else
	{
		$pass = clean($_POST["password"]);
		if (!preg_match("/^[a-zA-Z0-9@]*$/",$pass)) 
		{
			echo "Password can only contain alphabets,digits and '@'";
			return;
		}
	}

	if(empty($_POST["confirm_password"]))
	{
		echo "please enter password confirmation";
		return;
	}
	else
	{
		$cp = clean($_POST["confirm_password"]);
		if($pass != $cp){
			echo "Entered password do not match";		
			return;
		}		
	}
	//change users in $sql to your table name incase different and checkif parameters are same
	$sql = 'insert into users (username,email,password) values ("'. $user .'","'. $email .'","'. $pass .'")';	
	
	$retval = mysqli_query( $conn , $sql );

	if(!$retval)
	{
		die("could not insert data: \n".mysqli_error($conn));	
	}

	echo '<body  style="background-image: url(\'bird.jpg\');

	background-repeat: no-repeat;
	background-size: cover;
	background-position: center center;
	background-attachment: fixed;"> <pre>';

	echo 'username: '.$user."\n";
	echo 'email: '.$email."\n";

	echo '</pre></body>';

	mysqli_close($conn);
}

?>

	
