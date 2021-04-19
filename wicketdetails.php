<?php
require "config.php";
SESSION_START();
?>

<!DOCTYPE html>
<head>
<title>wicket details</title>
<link href="style.css" rel="stylesheet">
</head>

<body>
<div id="main-wrapper">
<form class="myform" action="wicketdetails.php" method="post">
<label>Batsman going back:</label>
<input name="batsoutname" type="text" class="inputvalues" placeholder="Name" required/><br></br>

<label>How wicket fallen:</label>
<select id="wayout" name="wayout" /required>
<option value="1">CAUGHT OUT</option>
<option value="2">BOWLED</option>
<option value="3">RUN OUT</option>
<option value="4">STUMP OUT</option>
</select><br></br>

<label>Wicket taken by:</label>
<input name="wickettaker" type="text" class="inputvalues" placeholder="wicket getter" /required><br></br>

<label>contribution in wicket taking:</label>
<input name="supporter" type="text" class="inputvalues" placeholder="contributer name" /required><br></br>

<label>New batsman:</label>
<input name="newbatsname" type="text" class="inputvalues" placeholder="New batsman" /required><br></br>

<center> <input name="submit3_btn" type="submit" id="signup-btn" value="SUBMIT"/></center>

</form>

<?php
if(isset($_POST['submit3_btn'])){
	$variable_name1=mysqli_real_escape_string($con,$_POST['batsoutname']);
	$variable_name2=mysqli_real_escape_string($con,$_POST['wickettaker']);
	$variable_name3=mysqli_real_escape_string($con,$_POST['supporter']);
	$variable_name4=mysqli_real_escape_string($con,$_POST['wayout']);
	
	if($variable_name4==1 || $variable_name4==2 || $variable_name4==4){
		$table_name=mysqli_real_escape_string($con,$_POST['batsoutname']);
		
		$query="insert into $table_name(score) values ('0')";
		$query_run=mysqli_query($con,$query);
	}
	
	if($variable_name4==3){
		$name1=mysqli_real_escape_string($con,$_SESSION['strikername']);
		if(strcmp($name1,$variable_name1)==0){
			$run=mysqli_real_escape_string($con,$_SESSION['run']);
			$table_name=mysqli_real_escape_string($con,$_POST['batsoutname']);
		$query="insert into $table_name(score) values ('$run')";
		$query_run=mysqli_query($con,$query);
		}
	}

switch($variable_name4){
	case 1:$wayout="caught";break;
	case 2;$wayout="bowled";break;
	case 3:$wayout="runout";break;
	case 4:$wayout="stumpout";break;
}

$query="update batting set supportername='$variable_name3',wickettaker='$variable_name2',status='OUT',wayout='$wayout' where batsname='$variable_name1'";
$query_run=mysqli_query($con,$query);

$table_name=mysqli_real_escape_string($con,$_POST['newbatsname']);
$query="create table if not exists  $table_name(balls int(10) AUTO_INCREMENT PRIMARY KEY,score varchar(20))";
$query_run=mysqli_query($con,$query);

$variable_name=mysqli_real_escape_string($con,$_POST['newbatsname']);
$query="insert into batting(batsname)values('$variable_name')";
$query_run=mysqli_query($con,$query);

if($_SESSION['strikername']==$_POST['batsoutname']){
	$_SESSION['strikername']=$_POST['newbatsname'];
}
else{
	$_SESSION['nonstrikername']=$_POST['newbatsname'];
}

$wayout=$_POST['wayout'];
if($wayout!=3){
	$variable_name1=mysqli_real_escape_string($con,$_POST['wickettaker']);
	$query="select noofwickets from bowling where bowlername='$variable_name1'";
	$query_run=mysqli_query($con,$query);
	
	if(mysqli_num_rows($query_run)>0){
		while($row=mysqli_fetch_array($query_run)){
			$value=$row['noofwickets'];
		}
	}
	$value+=1;
	$variable_name1=mysqli_real_escape_string($con,$_POST['wickettaker']);
	$query="update bowling set noofwickets='$value' where bowlername='$variable_name1'";
	$query_run=mysqli_query($con,$query);	
}

$next=mysqli_real_escape_string($con,$_SESSION['nextinnings']);
if($next==1){
	header('LOCATION:innings2score.php');
}
else{
	header('LOCATION:innings1score.php');
}
}
?>

</div>
</body>
</html>