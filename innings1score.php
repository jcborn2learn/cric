<?php
require "config.php";
SESSION_START();
?>

<!DOCTYPE html>
<head>
<title>Scoring</title>
<link href="style.css" rel="stylesheet">
</head>
<body>
<center><?php echo $_SESSION['team1']; echo " vs "; echo $_SESSION['team2']; ?></center>
<center><?php
if($_SESSION['tossresult']==1){
	if($_SESSION['tossbtn']==1){
		echo $_SESSION['team1']; echo "-bat";
	}
	else{
		echo $_SESSION['team2']; echo "-bat";
	}
}
else{
	if($_SESSION['tossbtn']==1){
		echo $_SESSION['team2']; echo "-bat";
	}
	else{
		echo $_SESSION['team1']; echo "-bat";
	}
}
?>
</center>

<div id="main-wrapper">
<form class="myform" action="innings1score.php" method="post">

<center>
<label>Striker:</label>
<input name="strikebtn" type="radio" id="strikebtn" value="1"/><?php echo $_SESSION['strikername'];?>
<input name="strikebtn" type="radio" id="strikebtn" value="2"/><?php echo $_SESSION['nonstrikername'];?></br></br>
</center>
<center>
<input type="checkbox" name="wide" id="chkb" value="1"/>Wide
<input type="checkbox" name="noball" id="chkb" value="2"/>No Ball 
<input type="checkbox" name="wicket" id="chkb" value="3"/>Wicket
</center>
<center><br></br>
<input name="run" type="submit" id="run" value="0"/>
<input name="run" type="submit" id="run" value="1"/>
<input name="run" type="submit" id="run" value="2"/><br></br>
<input name="run" type="submit" id="run" value="3"/>
<input name="run" type="submit" id="run" value="4"/>
<input name="run" type="submit" id="run" value="6"/>
</center>
<center><br></br><input name="scorecard" type="submit" id="signup-btn" value="Scorecard"/></center>
<?php
if(isset($_POST['scorecard'])){
	header('LOCATION:scorecard.php');
}
?>
<center><br></br><input name="inningsover" type="submit" id="signup-btn" value="Innings over"/></center>
</form>

<?php
if(isset($_POST['run'])){
	function extrainsert($con){
		$query="insert into totalscore(score) values('1')";
		$query_run=mysqli_query($con,$query);
	}
	function teamtotalscore($con):int{
		$variable_name=mysqli_real_escape_string($con,$_POST['run']);
		$query="insert into totalscore(score) values('$variable_name')";
		$query_run=mysqli_query($con,$query);
		
		$query="select sum(score) from totalscore";
		$query_run=mysqli_query($con,$query);
		if(mysqli_num_rows($query_run)>0){
			while($row=mysqli_fetch_array($query_run)){
				$result1=$row['sum(score)'];
			}
		}
		return $result1;
	}
	if(isset($_POST['wide']) && !isset($_POST['noball']) && !isset($_POST['wicket'])){
		$variable_name=mysqli_real_escape_string($con,$_POST['run']);  
		$val=$variable_name+1;
		$query="insert into peroverscore(score,ballresult)values('$val','wide')";
		$query_run=mysqli_query($con,$query);
		extrainsert($con);
		$result=teamtotalscore($con);
		echo "totalteam score is:"; echo $result;
	}
	if(isset($_POST['noball']) && !isset($_POST['wide']) && !isset($_POST['wicket'])){
	    $variable_name=mysqli_real_escape_string($con,$_POST['run']);  
	    $val=$variable_name+1;
	    $query="insert into peroverscore(score,ballresult)values('$val','noball')";
	    $query_run=mysqli_query($con,$query);
	    extrainsert($con);
	    $result=teamtotalscore($con);
	    echo "totalteam score is:"; echo $result;
	}
	if(isset($_POST['wicket']) && !isset($_POST['noball']) && !isset($_POST['wide'])){
	    $variable_name=mysqli_real_escape_string($con,$_POST['run']);
	    $query="insert into peroverscore(score,ballresult)values('$variable_name','wicket')";
	    $query_run=mysqli_query($con,$query);
	    $result=teamtotalscore($con);
	    echo "totalteam score is:"; echo $result;
	    header('LOCATION:wicketdetails.php');
	}
	if(isset($_POST['wide']) && !isset($_POST['noball']) && isset($_POST['wicket'])){
	    $variable_name=mysqli_real_escape_string($con,$_POST['run']);  
	    $val=$variable_name+1;
	    $query="insert into peroverscore(score,ballresult)values('$val','wide+wicket')";
	    $query_run=mysqli_query($con,$query);
	    extrainsert($con);
	    $result=teamtotalscore($con);
	    echo "totalteam score is:"; echo $result;
		header('LOCATION:wicketdetails.php');
	}
	if(!isset($_POST['wide']) && isset($_POST['noball']) && isset($_POST['wicket'])){
	    $variable_name=mysqli_real_escape_string($con,$_POST['run']);  
	    $val=$variable_name+1;
	    $query="insert into peroverscore(score,ballresult)values('$val','noball+wicket')";
	    $query_run=mysqli_query($con,$query);
	    extrainsert($con);
	    $result=teamtotalscore($con);
	    echo "totalteam score is:"; echo $result;
		header('LOCATION:wicketdetails.php');
	}
	$strikebtn=$_POST['strikebtn'];  
	if(!isset($_POST['wide']) && !isset($_POST['noball']) && !isset($_POST['wicket'])){
		$variable_name=mysqli_real_escape_string($con,$_POST['run']);
		$query="insert into peroverscore(score,ballresult)values('$variable_name','good')";
		$query_run=mysqli_query($con,$query);
		if($strikebtn==1){
			$table_name=mysqli_real_escape_string($con,$_SESSION['strikername']);
		    $run=mysqli_real_escape_string($con,$_POST['run']);
            $query="insert into $table_name(score)values($run)";
		    $query_run=mysqli_query($con,$query);
		}
		if($strikebtn==2){
			$table_name=mysqli_real_escape_string($con,$_SESSION['nonstrikername']);
		    $run=mysqli_real_escape_string($con,$_POST['run']);
            $query="insert into $table_name(score)values($run)";
		    $query_run=mysqli_query($con,$query);
		}
		$result=teamtotalscore($con);
		echo "Totalteam score is:"; echo $result;
	}
	$query="select count(status) from batting where status='OUT'";
    $query_run=mysqli_query($con,$query);
    if(mysqli_num_rows($query_run)>0){
		while($row=mysqli_fetch_array($query_run)){
			$value=$row['count(status)'];
		}
		echo "</br>";echo "Total wickets:";echo $value;echo "</br>";
	}
$query="select * from peroverscore";
$query_run=mysqli_query($con,$query);
$result=mysqli_num_rows($query_run);
if($result!=0){
    echo "<tr><td>score</td><td>ballresult</td></tr>";
	if(mysqli_num_rows($query_run)>0){
		while($row=mysqli_fetch_assoc($query_run)){
			echo "<table border='1'>";
			echo "<tr><td>".$row['score']."</td><td>".$row['ballresult']."</td></tr>";
			echo "</table>";
		}
	}
}

$query="select count(*) from peroverscore where ballresult in ('good','wicket')";
$query_run=mysqli_query($con,$query);
if(mysqli_num_rows($query_run)>0){
    while($row=mysqli_fetch_array($query_run)){
		$value=$row['count(*)'];
		$currentballs=$value;
	}
}
$query="select sum(oversbowled) from bowling";
$query_run=mysqli_query($con,$query);
if(mysqli_num_rows($query_run)>0){
    while($row=mysqli_fetch_array($query_run)){
		$noofovers=$row['sum(oversbowled)'];
	}
	echo "overs bowled:"; echo $noofovers; echo ".";echo $value;echo"</br>";
}
	$fromballs=($noofovers)*6+($value);
	$_SESSION['fromballs']=$fromballs;
	if($value==6){
		$query="insert into overallscoretable(balls,score,ballresult) select * from peroverscore";
		$query_run=mysqli_query($con,$query);
		
		$table_name=mysqli_real_escape_string($con,$_SESSION['bowlername']);
		$query="insert into $table_name(balls,score,ballresult) select *from peroverscore";
		$query_run=mysqli_query($con,$query);
		
		$table_name=mysqli_real_escape_string($con,$_SESSION['bowlername']);
		$query="select sum(score) from peroverscore where ballresult in ('good','wicket','wide','noball')";
		$query_run=mysqli_query($con,$query);
		if(mysqli_num_rows($query_run)>0){
			while($row=mysqli_fetch_array($query_run)){
				$value=$row['sum(score)'];
			}
		}
		$table_name=mysqli_real_escape_string($con,$_SESSION['bowlername']);
		$query="select oversbowled,scoregiven from bowling where bowlername='$table_name'";
        $query_run=mysqli_query($con,$query);
	    if(mysqli_num_rows($query_run)>0){
			while($row=mysqli_fetch_array($query_run)){
				$result1=$row['oversbowled'];
				$result=$row['scoregiven'];
			}
		}
		$result1+=1;
		$result+=$value;
		$table_name=mysqli_real_escape_string($con,$_SESSION['bowlername']);
		$query="update bowling set oversbowled='$result1',scoregiven='$result' where bowlername='$table_name'";
        $query_run=mysqli_query($con,$query);
		
		$query="truncate table peroverscore";
		$query_run=mysqli_query($con,$query);
		
		$query="select sum(oversbowled) from bowling";
		$query_run=mysqli_query($con,$query);
		if(mysqli_num_rows($query_run)>0){
			while($row=mysqli_fetch_array($query_run)){
				$noofovers=$row['sum(oversbowled)'];
			}
		}
		if($noofovers==$_SESSION['overs']){
			echo '<script type="text/javascript"> alert("Enter Innings over.")</script>';
		}
		else{
			header('LOCATION:bowlerentry.php');
		}
	}
}
?>
<?php
if(isset($_POST['run'])){
	$_SESSION['run']=$_POST['run'];
	
	$table_name1=mysqli_real_escape_string($con,$_SESSION['strikername']);
	$query="select count(*) from $table_name1";
	$query_run=mysqli_query($con,$query);
	if(mysqli_num_rows($query_run)>0){
		while($row=mysqli_fetch_array($query_run)){
			$result1=$row['count(*)'];
			echo $_SESSION['strikername'];
		}
	}
	$query="select count(*) from $table_name1 where score='4'";
	$query_run=mysqli_query($con,$query);
	if(mysqli_num_rows($query_run)>0){
		while($row=mysqli_fetch_array($query_run)){
			$result2=$row['count(*)'];
		}
	}	
	$query="select count(*) from $table_name1 where score='6'";
	$query_run=mysqli_query($con,$query);
	if(mysqli_num_rows($query_run)>0){
		while($row=mysqli_fetch_array($query_run)){
			$result3=$row['count(*)'];
		}
	}
    $query="select sum(score) from $table_name1";
	$query_run=mysqli_query($con,$query);
	if(mysqli_num_rows($query_run)>0){
		while($row=mysqli_fetch_array($query_run)){
			$result4=$row['sum(score)'];
		}
	}
	$table_name=mysqli_real_escape_string($con,$_SESSION['strikername']);
	$query="update batting set runs='$result4',balls='$result1',fours='$result2',sixes='$result3' where batsname='$table_name1'";               
	$query_run=mysqli_query($con,$query);
	
	echo "<table border='1'>";
	echo "<tr><td> batsman </td><td> R </td><td> B </td><td> 4s </td><td> 6s </td></tr>";
	echo "<tr><td>".$table_name1."</td><td>".$result4."</td><td>".$result1."</td><td>".$result2."</td><td>".$result3."</td></tr>";
	echo "</table>";
	
	$table_name=mysqli_real_escape_string($con,$_SESSION['nonstrikername']);
	$query="select count(*) from $table_name";
	$query_run=mysqli_query($con,$query);
	if(mysqli_num_rows($query_run)>0){
		while($row=mysqli_fetch_array($query_run)){
			$result1=$row['count(*)'];
			echo $_SESSION['nonstrikername'];
		}
	}
	$query="select count(*) from $table_name where score='4'";
	$query_run=mysqli_query($con,$query);
	if(mysqli_num_rows($query_run)>0){
		while($row=mysqli_fetch_array($query_run)){
			$result2=$row['count(*)'];
		}
	}	
	$query="select count(*) from $table_name where score='6'";
	$query_run=mysqli_query($con,$query);
	if(mysqli_num_rows($query_run)>0){
		while($row=mysqli_fetch_array($query_run)){
			$result3=$row['count(*)'];
		}
	}
    $query="select sum(score) from $table_name";
	$query_run=mysqli_query($con,$query);
	if(mysqli_num_rows($query_run)>0){
		while($row=mysqli_fetch_array($query_run)){
			$result4=$row['sum(score)'];
		}
	}
	$table_name=mysqli_real_escape_string($con,$_SESSION['nonstrikername']);
	$query="update batting set runs='$result4',balls='$result1',fours='$result2',sixes='$result3' where batsname='$table_name'";               
	$query_run=mysqli_query($con,$query);
	
	echo "<table border='1'>";
	echo "<tr><td> batsman </td><td> R </td><td> B </td><td> 4s </td><td> 6s </td></tr>";
	echo "<tr><td>".$table_name."</td><td>".$result4."</td><td>".$result1."</td><td>".$result2."</td><td>".$result3."</td></tr>";
	echo "</table>";
}
?>
<?php
if(isset($_POST['inningsover'])){
	$_SESSION['inningsover']=$_POST['inningsover'];
	
	$query="select sum(score) from overallscoretable";
	$query_run=mysqli_query($con,$query);
	if(mysqli_num_rows($query_run)>0){
		while($row=mysqli_fetch_array($query_run)){
			$target=$row['sum(score)'];
		}
	}
	$target+=1;
	$_SESSION['target']=$target;
	
	header('LOCATION:scorecard.php');
}
?>
</div>
</body>
</html>