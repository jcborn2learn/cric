<?php
require "config.php";
SESSION_START();
?>

<!DOCTYPE html>
<head>
<title>bowler entry</title>
<link href="style.css" rel="stylesheet">
</head>

<body>
<div id="main-wrapper">
<form class="myform" action="bowlerentry.php" method="post">
<label> New bowler name </label>
<input name="newbowlername" type="text" class="inputvalues" placeholder="name" /required><br></br>
<center> <input name="submit4_btn" type="submit" id="signup-btn" value="SUBMIT"/></center>
</form>
</div>

<?php
if(isset($_POST['submit4_btn'])){
	$table_name=mysqli_real_escape_string($con,$_POST['newbowlername']);
	$query="create table if not exists  $table_name(balls int(10),score varchar(20),ballresult varchar(40))";
	$result=mysqli_query($con,$query);
	
	$variable_name=mysqli_real_escape_string($con,$_POST['newbowlername']);
	$query="insert into bowling(bowlername)values('$variable_name')";
	$query_run=mysqli_query($con,$query);
	
	$_SESSION['bowlername']=$_POST['newbowlername'];
	
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