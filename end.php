<?php
require "config.php";
SESSION_START();
?>

<!DOCTYPE html>
<head>

<link href="style.css" rel="stylesheet">
<body>

<div id="main-wrapper">
<center>
<form class="myform" action="end.php" method="post">
<center><input name="nextinnings" type="submit" id="signup-btn" value="Next Innings"/></center><br></br>
<center><input name="matchcompleted" type="submit" id="signup-btn" value="Match completed"/></center>
</center>
</form>

<?php
if(isset($_POST['nextinnings']) || isset($_POST['matchcompleted'])){
	$query="select batsname from batting";
	$query_run=mysqli_query($con,$query);
	if(mysqli_num_rows($query_run)>0){
		while($row=mysqli_fetch_array($query_run)){
			$batsname=$row['batsname'];
			$sql="drop table $batsname";
			$result=mysqli_query($con,$sql);
		}
	}
	
	$query="select bowlername from bowling";
	$query_run=mysqli_query($con,$query);
	if(mysqli_num_rows($query_run)>0){
		while($row=mysqli_fetch_array($query_run)){
			$bowlername=$row['bowlername'];
			$sql="drop table $bowlername";
			$result=mysqli_query($con,$sql);
		}
	}
	
	$query="truncate table batting";
	$query_run=mysqli_query($con,$query);
	
	$query="truncate table bowling";
	$query_run=mysqli_query($con,$query);
	
	$query="truncate table overallscoretable";
	$query_run=mysqli_query($con,$query);
	
	$query="truncate table peroverscore";
	$query_run=mysqli_query($con,$query);
	
	$query="truncate table totalscore";
	$query_run=mysqli_query($con,$query);
}

if(isset($_POST['nextinnings'])){
	$_SESSION['nextinnings']=1;
	$name1=mysqli_real_escape_string($con,$_SESSION['matchid']);
	$name2=mysqli_real_escape_string($con,$_SESSION['team1']);
	$name3=mysqli_real_escape_string($con,$_SESSION['team2']);
	$name4=mysqli_real_escape_string($con,$_SESSION['tossbtn']);
	$name5=mysqli_real_escape_string($con,$_SESSION['tossresult']);
	$name6=mysqli_real_escape_string($con,$_SESSION['overs']);
	
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
	
		$query="insert into matchdetails(matchid,team1,team2,tossbtn,tossresult,overs) values('$name1+','$name2','$name3','$table1','$tab1','$name6')";
	    $query_run=mysqli_query($con,$query);
		
	    $query="insert into scoretable(matchid,inningsno) values ('$name1+','2')";
	    $query_run=mysqli_query($con,$query);
		
		$matchid2="$name"."10022002";
		$_SESSION['matchid2']=$matchid2;
		header('LOCATION:batsmanentries.php');
}
if(isset($_POST['matchcompleted'])){
	SESSION_DESTROY();
	header('LOCATION:teamentries.php');
}
?>

</div>
</body>
</html>
