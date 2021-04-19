<?php
require "config.php";
SESSION_START();
?>

<!DOCTYPE html>
<head>
<title>scorecard</title>
<link href="style.css" rel="stylesheet">
</head>

<body>
<center>
<?php

echo "<br></br>";

$query="select * from batting";
$query_run=mysqli_query($con,$query);
echo "<table border='1'>";
echo "<tr><td>Batsman</td><td>R</td><td>B</td><td>4s</td><td>6s</td><td>contributer</td><td>wicket-taker</td><td>wayout</td><td>status</td></tr>";

if(mysqli_num_rows($query_run)>0){
	while($row=mysqli_fetch_assoc($query_run)){
		echo "<tr><td>".$row['batsname']."</td><td>".$row['runs']."</td><td>".$row['balls']."</td><td>".$row['fours']."</td><td>".$row['sixes']."</td><td>".$row['supportername']."</td><td>".$row['wickettaker']."</td><td>".$row['wayout']."</td><td>".$row['status']."</td></tr>";
	}
}
echo "</table>";
echo "<br></br>";

$query="select * from bowling";
$query_run=mysqli_query($con,$query);
echo "<table border='1'>";
echo "<tr><td><Bowler</td><td>Overs</td><td>R</td><td>W</td></tr>";

if(mysqli_num_rows($query_run)>0){
	while($row=mysqli_fetch_assoc($query_run)){
		echo "<tr><td>".$row['bowlername']."</td><td>".$row['oversbowled']."</td><td>".$row['scoregiven']."</td><td>".$row['noofwickets']."</td></tr>";
	}
}

echo "</table>";
echo "<br></br>";

?>
</center>

<form class=="myform" action="scorecard.php" method="post">
<center> <input name="backbtn" type="submit" id="signup-btn" value="BACK"/></center><br></br>
<center> <input name="endinnings" type="submit" id="signup-btn" value="End innings"/></center>
</form>

<?php
if(isset($_POST['backbtn'])){
	$next=mysqli_real_escape_string($con,$_SESSION['nextinnings']);
	if($next==1){
		header('LOCATION:innings2score.php');
	}
	else{
		header('LOCATION:innings1score.php');
	}
}

if(isset($_POST['endinnings'])){
	if($next==1){
		header('LOCATION:end.php');
	}
	else{
		header('LOCATION:end.php');
	}
}
?>