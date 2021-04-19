<?php
require "config.php";
SESSION_START();
?>

<!DOCTYPE html>
<head>
<title>Batting entry</title>
<link href="style.css" rel="stylesheet">
</head>

<body>
<div id="main-wrapper">
<form class="myform" action="batsmanentries.php" method="post">
<center>
<label><b>striker name:</b></label>
<input name="strikername" type="text" class="inputvalues" placeholder="Enter striker name" required/><br></br>
<label><b>Non-striker name:</b></label>
<input name="nonstrikername" type="text" class="inputvalues" placeholder="Enter non-striker name" required/><br></br>
<label><b>Bowler name:</b></label>
<input name="bowlername" type="text" class="inputvalues" placeholder="Enter Bowler name" required/><br></br>
<input name="submit1_btn" type="submit" id="signup_btn" value="SUBMIT"/>
</center>
</form>
</div>

<?php
if(isset($_POST['submit1_btn'])){
	$variable_name=mysqli_real_escape_string($con,$_POST['strikername']);
	$query="insert into batting(batsname) values('$variable_name')";
	$query_run=mysqli_query($con,$query);
	
	$variable_name=mysqli_real_escape_string($con,$_POST['nonstrikername']);
	$query="insert into batting(batsname) values('$variable_name')";
	$query_run=mysqli_query($con,$query);
	
	$variable_name=mysqli_real_escape_string($con,$_POST['bowlername']);
	$query="insert into bowling(bowlername) values('$variable_name')";
	$query_run=mysqli_query($con,$query);
	
	$table_name=mysqli_real_escape_string($con,$_POST['strikername']);
    $query="create table if not exists  $table_name(balls int(10) AUTO_INCREMENT PRIMARY KEY,score varchar(20))";
	$result=mysqli_query($con,$query);
	
	$table_name=mysqli_real_escape_string($con,$_POST['nonstrikername']);
    $query="create table if not exists  $table_name(balls int(10) AUTO_INCREMENT PRIMARY KEY,score varchar(20))";
	$result=mysqli_query($con,$query);
	
	$table_name=mysqli_real_escape_string($con,$_POST['bowlername']);
	$query="create table if not exists  $table_name(balls int(10),score varchar(20),ballresult varchar(40))";
	$result=mysqli_query($con,$query);
	
	$_SESSION['strikername']=$_POST['strikername'];
	$_SESSION['nonstrikername']=$_POST['nonstrikername'];
    $_SESSION['bowlername']=$_POST['bowlername'];
	
	$next=mysqli_real_escape_string($con,$_SESSION['nextinnings']);
	if($next==1){
		header('LOCATION:innings2score.php');
	}
	else{
		header('LOCATION:innings1score.php');
	}
}

?>
</body>
</html>