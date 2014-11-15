<!doctype html>
<html>
<head>

<meta charset="utf-8">
<link rel="shortcut icon" href="header/favicon.ico" type="image/x-icon">
<link href="//fonts.googleapis.com/css?family=PT+Sans:400italic,400,700italic,700" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" media="(min-width:601px)" href="accordion/accordion.css">
	<link rel="stylesheet" type="text/css"  media="(max-width: 600px)" href="accordion/mobile.css" />
	<link rel="stylesheet" type="text/css"  media="(max-width: 360px)" href="accordion/mobile360.css" />
<script type="text/javascript" src="accordion/modernizr.acc.js"></script>
<link href='http://fonts.googleapis.com/css?family=Crimson+Text' rel='stylesheet' type='text/css'>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js">
</script>
<style>

i {font-size:75%}

</style>


</head>

<body>
<?php

require_once "db.php";
$vID = $_POST['vID'];
 $vName=$_POST['vName'];
 $vCity=$_POST['vCity'];
 $vCountry=$_POST['vCountry'];


$c=28;

echo'
<div class="sidebar" >
<p class="title">'.$vName.' in <br />'.$vCity.', '.$vCountry.' </p>

';


$stmt = $PDO->query("SELECT play.source as play_source, venueName, role_source, performanceDate, performanceNotes, roleName, playTitle, venueid, year, role_comment, play_comment
FROM performance, PerformanceRoles, role, venues, play
WHERE performance.idPerformance = PerformanceRoles.idPerformance
AND performance.idVenue = venues.venueid
AND PerformanceRoles.roleId = role.roleid
AND play.playid = role.playid
AND NOT venueName = 'Unknown Theater'
AND NOT latitude = 'NULL'
AND NOT performanceDate = 'NULL'
AND venueid = '".$vID."'
GROUP BY performanceDate, roleName ASC");



$counter=1;
$when=0;
$b=0;

while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
   $Venue = $row['venueName'];
   $city = $row['city'];
   $year = $row['year'];
   $role = $row['roleName'];
   $title = $row['playTitle'];
	$notes = $row['performanceNotes'];
	$pDate = $row['performanceDate'];
	$pDate= date("F d, Y",strtotime($row['performanceDate']));
	$roleC = $row['role_comment'];
	$playC = $row['play_comment'];
	$roleSource=$row['role_source'];
	$playSource=$row['play_source'];
	

	
	if ($when == 0){
		echo '
		<section class="ac-container">
		<div>
		<input id="ac-'.$counter.'" name="accordion-1" type="radio" />
		<label for="ac-'.$counter.'">'.$year.'</label>
		<article class="ac-variable">
		<p><b style="font-size:110%">'.$pDate.'</b><br /<br />';
		if ($roleC != "NULL" && $playC != "NULL"){
			echo'
			Played <a class="comment" alt="'.$role.'" title="'.$roleC.'<br />  <i><b>Source:</b> '.$roleSource.'</i>">  '.$role.' </a> in <a class="comment" alt="'.$title.'" title="'.$playC.'<br /> <i><b>Source: </b> '.$playSource.'</i>"> '.$title.'</a><br />
			'.$notes.'</p>
			';
			$when = $year;
				}
		elseif ($roleC != "NULL"){
			echo'
			Played <a class="comment" alt="'.$role.'" title="'.$roleC.'<br />  <i><b>Source:</b> '.$roleSource.'</i>">  '.$role.' </a>
			in '.$title.'<br />
			'.$notes.'</p>
			';
			$when = $year;
			}
		elseif ($playC != "NULL"){
			echo'
				Played '.$role.' in 
				<a class="comment" alt="'.$title.'" title="'.$playC.'<br /> <i><b>Source: </b> '.$playSource.'</i>"> '.$title.'</a><br />
				'.$notes.'</p>
				';
				$when = $year;
		}
		else {
			echo'
			Played '.$role.' in '.$title.'<br />
			'.$notes.'</p>
			';
			$when = $year;
			}
		}	
	else if ($when == $year ){
		echo '
		<p><b style="font-size:110%">'.$pDate.'</b><br /<br />';
		
		if ($roleC != "NULL" && $playC != "NULL"){
			echo'
			Played <a class="comment" alt="'.$role.'" title="'.$roleC.'<br />  <i><b>Source:</b> '.$roleSource.'</i>">  '.$role.' </a> in <a class="comment" alt="'.$title.'" title="'.$playC.'<br /> <i><b>Source: </b> '.$playSource.'</i>"> '.$title.'</a><br />
			'.$notes.'</p>
			';
			$when = $year;
				}
		elseif ($roleC != "NULL"){
				echo'
				Played <a class="comment" alt="'.$role.'" title="'.$roleC.'<br />  <i><b>Source:</b> '.$roleSource.'</i>">  '.$role.' </a>
				in '.$title.'<br />
				'.$notes.'</p>
				';
				$when = $year;
			}
		elseif ($playC != "NULL"){
			echo'
				Played '.$role.' in 
				<a class="comment" alt="'.$title.'" title="'.$playC.'<br /> <i><b>Source: </b> '.$playSource.'</i>"> '.$title.'</a><br />
				'.$notes.'</p>
				';
				$when = $year;
		}
		else {
			echo'
			Played '.$role.' in '.$title.'<br />
			'.$notes.'</p>
			';
			$when = $year;
			}
	}
	else if ($when < $year){
		echo '
		</article>
		</div>
		</section>
		
		<section class="ac-container">
		<div>
		<input id="ac-'.$counter.'" name="accordion-1" type="radio" />
		<label for="ac-'.$counter.'">'.$year.'</label>
		<article class="ac-variable">
		<p><b style="font-size:110%">'.$pDate.'</b><br /<br />';
		if ($roleC != "NULL" && $playC != "NULL"){
			echo'
			Played <a class="comment" alt="'.$role.'" title="'.$roleC.'<br />  <i><b>Source:</b> '.$roleSource.'</i>">  '.$role.' </a> in <a class="comment" alt="'.$title.'" title="'.$playC.'<br /> <i><b>Source: </b> '.$playSource.'</i>"> '.$title.'</a><br />
			'.$notes.'</p>
			';
			$when = $year;
				}
		elseif ($roleC != "NULL"){
				echo'
				Played <a class="comment" alt="'.$role.'" title="'.$roleC.'<br />  <i><b>Source:</b> '.$roleSource.'</i>">  '.$role.' </a>
				in '.$title.'<br />
				'.$notes.'</p>
				';
				$when = $year;
			}
		elseif ($playC != "NULL"){
			echo'
				Played '.$role.' in 
				<a class="comment" alt="'.$title.'" title="'.$playC.'<br /> <i><b>Source: </b> '.$playSource.'</i>"> '.$title.'</a><br />
				'.$notes.'</p>
				';
				$when = $year;
		}
		else {
			echo'
			Played '.$role.' in '.$title.'<br />
			'.$notes.'</p>
			';
			$when = $year;
			}
		
	}
	else {
		echo '</article>
			  </div>
			  </section>';
			  $when = $year;
		}
	$counter++;
}

echo '</div>';

?>


</body>
</html>

<script type="text/javascript">
$(document).on('click','.comment', function() {
    var Role = $(this).attr("title");
    var tt = $(this).attr("alt");
		$("#moreInfo").attr("style","visibility:visible").html("<a id=close onclick=closeIt()><img id=close src=accordion/close.png></a><h3>&nbsp;&nbsp;"+tt+"</h3><p>"+Role+"</p>");
 	
//  	else {
//  	$("#moreInfo").attr("style","visibility:visible").html("<a id=close onclick=closeIt()><img id=close src=accordion/close.png></a><p>This map plots the known performances of esteemed 19th century stage actor Ira Aldridge (July 24, 1807 - August 7, 1867). Although many holes exist in this tracing of his life between 1824 and 1866, when possible we have included the name of the venue at which he performed, as well as the roles and plays he took on.  </p>");
//  	}
 });


function closeIt(){
document.getElementById("moreInfo").style.visibility="hidden";
var Role = '';
}

</script>