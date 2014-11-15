
<?php
$dsn = 'mysql:host=mysql.19thcenturyacts.com;dbname=aldridge';
$username = 'ira_aldridge_db';
$password = 'AK3169AM!';

try{
$PDO = new PDO($dsn, $username, $password);
}
catch( PDOEXCEPTION $Exception){
	throw new MyDatabaseException ($Exception ->getMessage() ,
	(int)$Exception->getCode());
	}
?>


  
