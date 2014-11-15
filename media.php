


<!DOCTYPE html>
<html>
<head>
	<title>Testing Database</title>
	<meta charset="utf-8" />
	
	</head>
<body>


<?php

require_once "db.php";

$stmt = $PDO->query("SELECT * FROM media");
while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
   $file = $row['mediaLink'];
   $notes = $row['notes'];
   $title = current(explode('.', $row['mediaLink']));

    echo '
  	
                <a href="ISO/images/'.$file.'" ><img src="ISO/images/'.$file.'" width="282"  alt="image" /></a>
                <p>'.$notes.'</p>
                <p>'.$title.'</p>
                ';
}


?>

</body>
</html>


