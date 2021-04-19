<?php
require "config.php";
SESSION_START();
?>

<!DOCTYPE html>
<head>
<title>Team Entries</title>
<link href="style.css" rel="stylesheet">
</head>

<body>
<div id="main-wrapper">
<form class="myform" action="teamentries.php" method="post">
<center>
<label><b>Match code</b></label>
<input name="matchid" type="text" class="inputvalues" placeholder="Unique match id" required/><br></br>
<label><b>Team1</b></label>
<input name="team1" type="text" class="inputvalues" placeholder="Enter team1" required/><br></br>
<label><b>Team2</b></label>
<input name="team2" type="text" class="inputvalues" placeholder="Enter team2" required/><br></br>
<label><b>Toss won:</b></label>
<input name="tossbtn" type="radio" id="tossbtn" value="1"/>Team1
<input name="tossbtn" type="radio" id="tossbtn" value="2"/>Team2<br></br>
<input name="tossresult" type="radio" id="tossresult" value="1"/>Bat
<input name="tossresult" type="radio" id="tossresult" value="2"/>Ball<br></br>
<label><b>Overs to play</b></label>
<input name="overs" type="number" class="inputvalues" placeholder="Enter overs" required/><br></br>
<input name="submit_btn" type="submit" id="signup_btn" value="Start Match"/>
</center>
</form>


<?php

if(isset($_POST['submit_btn'])){
	$name1=mysqli_real_escape_string($con,$_POST['matchid']);
	$name2=mysqli_real_escape_string($con,$_POST['team1']);
	$name3=mysqli_real_escape_string($con,$_POST['team2']);
	$name4=mysqli_real_escape_string($con,$_POST['tossbtn']);
	$name5=mysqli_real_escape_string($con,$_POST['tossresult']);
	$name6=mysqli_real_escape_string($con,$_POST['overs']);
	
	$query="select * from matchdetails where matchid='$name1'";
	$query_run=mysqli_query($con,$query);
	if(mysqli_num_rows($query_run)>0){
		echo "Change Match-id";
		echo '<script type="text/javascript"> alert("Change matchid..")</script>';
	}
	else{
		if($name4==1){
			$table1=$name2;
		}
		else{
		    $table1=$name3;
		}
		
		if($name5==1){
			$tab1="bat";
		}
		else{
			$tab1="ball";
		}
		
	    $query="insert into matchdetails(matchid,team1,team2,tossbtn,tossresult,overs) values('$name1','$name2','$name3','$table1','$tab1','$name6')";
	    $query_run=mysqli_query($con,$query);
	
	    $query="insert into scoretable(matchid,inningsno) values ('$name1','1')";
	    $query_run=mysqli_query($con,$query);
	
	    $_SESSION['matchid']=$_POST['matchid'];
	    $_SESSION['team1']=$_POST['team1'];
	    $_SESSION['team2']=$_POST['team2'];
	    $_SESSION['tossbtn']=$_POST['tossbtn'];
	    $_SESSION['tossresult']=$_POST['tossresult'];
	    $_SESSION['overs']=$_POST['overs'];
	    header('LOCATION:batsmanentries.php');
	}
}
?>
</div>
</body>
</html>