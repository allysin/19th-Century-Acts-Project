	<!DOCTYPE html>
<html>
<head>
<style type="text/css">
body {padding-top:70px}
</style>
	
<title>Isotope Aldridge</title>
<link rel="stylesheet" href="stylesISO.css">
<link rel="stylesheet" href="overlay.css">
<link href="//fonts.googleapis.com/css?family=PT+Sans:400italic,400,700italic,700" rel="stylesheet" type="text/css">
<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
 <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

<script src="js/bootstrap.min.js"></script>
<script src="http://code.jquery.com/jquery-latest.js" type="text/javascript"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
<script src="js/jquery.isotope.js" type="text/javascript"></script>



</head>
<body>
 
<!-- JS for isotope masonry -->
<script type="text/javascript">
 $(window).load(function(){
    var $container = $('.portfolioContainer');
    $container.isotope({
        filter: '*',
        animationOptions: {
            duration: 750,
            easing: 'linear',
            queue: false
        }
    });
 
    $('.portfolioFilter a').click(function(){
        $('.portfolioFilter .current').removeClass('current');
        $(this).addClass('current');
 
        var selector = $(this).attr('data-filter');
        $container.isotope({
            filter: selector,
            animationOptions: {
                duration: 750,
                easing: 'linear',
                queue: false
            }
         });
         return false;
    });
});
 
</script>


<!-- filter for labels -->

<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container portfolioFilter">
    	<ul class="nav navbar-nav">
        	<li><a class="current" href="#" data-filter="*">All Categories</a></li>
        	<li><a href="#" data-filter=".people">People</a></li>
        	<li><a href="#" data-filter=".places">Places</a></li>
        	<li><a href="#" data-filter=".artifacts">Artifacts</a></li>
        	<li><a href="#" data-filter=".theater">Theater</a></li>
   	 	</ul>
    </div>
</nav>




 <!-- images -->
 
 
 



<div class="portfolioContainer">

<?php

require_once "db.php";

$stmt = $PDO->query("SELECT * FROM media");
while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
   $file = $row['mediaLink'];
   $notes = $row['notes'];
   //current explode for title retrieves everything before the period in the file name
   $title = current(explode('.', $row['mediaLink']));
   $class = $row['classTag'];

    echo '
  	
               


		<div class="isoframe '.$class.'">
	
    		<a href="MediaImages/'.$file.'">
    			<img class="isoImage" src="MediaImages/'.$file.'" alt="'.$title.'" >
    		</a>
        	<div class="overlay">

    			<div class="iso_title">
        			<h3 class="iso_title">'.$title.'</h3>
    			</div>
    			<div class="iso_info">
				'.$notes.'
    			</div>
			</div>
		</div>
		
		';
	
	
	}	
		
	?>	
	</div>

 
</div>
</body>
</html>

    