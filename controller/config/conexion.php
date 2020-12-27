 <?php 
 
$con = mysqli_connect("localhost","root","admin");
//$con = mysqli_connect("localhost","root","admin");
 //mysql_query('SET NAMES \'utf8\'');
 //mysqli_set_charset('utf8'); 
 $db=mysqli_select_db($con,"mezapos") or die("Error base de datos");
 //A�adimos el fix UTF-8	
 //mysqli_query("SET NAMES 'utf8'"); 
?>