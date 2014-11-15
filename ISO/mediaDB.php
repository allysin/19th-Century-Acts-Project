	<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8">
<meta name="description" content="Visualizing Digital Humanities: Ira Aldridge 19th Century Actor">
<meta name="keywords" content="19th Century, 19th Century Acts, Theater, Theatre, Aldridge, Acting, Rhetorical Acting, Digital Humanities, Historical Visualizations, Henry Siddons">
	
<title>Sights & Sounds</title>
<link rel="stylesheet" href="stylesISO.css">
<link rel="stylesheet" href="overlay.css">
<link href="//fonts.googleapis.com/css?family=PT+Sans:400italic,400,700italic,700" rel="stylesheet" type="text/css">
<link href="http://fonts.googleapis.com/css?family=Crimson+Text" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="colorbox/colorbox.css" />
<link rel="shortcut icon" href="../header/favicon.ico" type="image/x-icon">

<script src="http://code.jquery.com/jquery-latest.js" type="text/javascript"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
<script src="js/jquery.isotope.js" type="text/javascript"></script>
<script src="js/jquery.lazyload.js" type="text/javascript"></script>
<script src="js/jquery.preloader.js" type="text/javascript"></script>
<script src="colorbox/jquery.colorbox-min.js" type="text/javascript"></script>


		<script>
			$(document).ready(function(){
				//Examples of how to assign the Colorbox event to elements
				$(".group1").colorbox({rel:'group1'});
				$(".group2").colorbox({rel:'group2', transition:"fade"});
				$(".group3").colorbox({rel:'group3', transition:"fade", innerWidth:640, innerHeight:390});
				$(".group4").colorbox({rel:'group4', slideshow:true});
				$(".ajax").colorbox();
				$(".youtube").colorbox({iframe:true, innerWidth:640, innerHeight:390});
				$(".vimeo").colorbox({iframe:true, innerWidth:500, innerHeight:409});
				$(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
				$(".inline").colorbox({inline:true, width:"50%"});
				$(".callbacks").colorbox({
					onOpen:function(){ alert('onOpen: colorbox is about to open'); },
					onLoad:function(){ alert('onLoad: colorbox has started to load the targeted content'); },
					onComplete:function(){ alert('onComplete: colorbox has displayed the loaded content'); },
					onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
					onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
				});

				$('.non-retina').colorbox({rel:'group5', transition:'none'})
				$('.retina').colorbox({rel:'group5', transition:'none', retinaImage:true, retinaUrl:true});
				
				//Example of preserving a JavaScript event for inline calls.
				$("#click").click(function(){ 
					$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
					return false;
				});
			});



// $(function(){
//     $("a.group3").hover(function(){
// 		$(this).attr('alt',$(this).attr('title'));
//         $(this).attr('title', '');},
//         function(){
// 		$(this).attr('title',$(this).attr('alt'));
//         });
// });
// 
// $(function(){
//     $("a.youtube").hover(function(){
// 		$(this).attr('alt',$(this).attr('title'));
//         $(this).attr('title', '');},
//         function(){
// 		$(this).attr('title',$(this).attr('alt'));
//         });
// });

</script>

</head>
<body>




<!-- filter for labels -->
<div class="header">
<ul>
<li><a href="../index.html"><img src="../header/compound_logo.jpg" align = "left" alt="19th Century Acts logo"></a></li>
<li id="about"><a href="../about.html"><img src="../header/about_button.jpg" alt="about"></a></li>
</ul>

<br />
<h1>Sights &amp; Sounds</h1>
<div class="portfolioFilter">
    <a href="#" data-filter="*" class="current">all images</a>
    <a href="#" data-filter=".People">people</a>
    <a href="#" data-filter=".Plays">plays</a>
    <a href="#" data-filter=".Artifacts">artifacts</a>
    <a href="#" data-filter=".Theaters">theaters</a>
 	<a href="#" data-filter=".Roles">roles</a>
 	<a href="#" data-filter=".Gestures">gestures</a>
 	<a href="#" data-filter=".Listen">listen</a>
</div>
</div> 
 <!-- images -->
 
 
 



<div id="container">

<?php

require_once "db.php";

$stmt = $PDO->query("SELECT * FROM media ORDER by displayName ");
while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
   $file = $row['mediaLink'];
   $description= $row['description'];
   $source=$row['source'];
   $displayName=$row['displayName'];
   //current explode for title retrieves everything before the period in the file name
   $class = $row['classTag'];
   $mediaType = $row['mediaType'];
   $videoImage = $row['videoImage'];
   

	if ($mediaType == 'photo'){
    echo '
		<div class="isoFrame '.$class.'">
	
    		<a href="MediaImages/'.$file.'" class="group3" title="<b>'.$displayName.'</b>
    		</br>'.$description.'</br><br/><b>Source:</b><i> '.$source.'</i>">
    			<img class="isoImage" src="MediaImages/'.$file.'" alt="'.$displayName.'" >
    		</a>
    		
        	<div class="overlay">

    			<div class="iso_title">
        			<h3 class="iso_title">'.$displayName.'</h3>
    			</div>
    			
			</div>
		</div>
		
		';	
		}
	if ($mediaType == 'video'){
	 echo '
		<div class="isoFrame '.$class.'">
	
    		<a href="'.$file.'" class="youtube cboxElement" title="<b>'.$displayName.'</b>
    		</br>'.$description.'</br><br/><b>Source:</b><i> '.$source.'</i>">
    			<img class="isoImage" src="MediaImages/'.$videoImage.'" alt="'.$displayName.'" >
    		</a>
    		
        	<div class="overlay">

    			<div class="iso_title">
        			<h3 class="iso_title">'.$displayName.'</h3>
    			</div>
    			
			</div>
		</div>
		
		';
	
	}
}	
		
	?>	
	</div>




<div class="goodbye">
	<img src="../footer/teal_circle.png" alt="teal circle">
	<table cellspacing=0>
	<tr class="top">
		<td>Home</td>
		<td>About</td>
		<td>Tools</td>
	</tr>
	<tr>
		<td class="med"><a href=""../index.html""> 19th Century Acts!</a></td>
		<td class="med"><a href="../about.html">About 19th Century Acts!</a></td>
		<td class="med"><a href="../map.php">Mapping Ira Aldridge</a></td>
		<td class="med"><a href="mediaDB.php">Sights & Sounds</a></td>
	</tr>
	<tr>
		<td> &nbsp;</td>
		<td class="med"><a href= "mailto:amanjo@umich.edu">Contact Us</a></td>
		<td class="med"><a href="../gestures.html">Acting Styles</a></td>
		<td class="med"><a href="../resources.html">Resources</a></td>

	</tr>
	</table>
</div>


</body>
</html>
<!-- JS for isotope masonry -->
<script type="text/javascript">
jQuery(document).ready(function($) {

var $win = $(window),
    $imgs = $("img");
var $container = $('#container').imagesLoaded( function() {
  $container.isotope({
    // options
  });
});

    $container.isotope({
    onLayout: function() {
        $win.trigger("scroll");
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
    
    $('#container').preloader({
  loader: 'preload/726.GIF',
  fadeIn: 700,
  delay : 200 
});

$imgs.lazyload({
    failure_limit: Math.max($imgs.length - 1, 0)
});

});


</script>
