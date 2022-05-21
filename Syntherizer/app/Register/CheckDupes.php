

 <?php
// CHECK THE DATABASE FOR EXISTING USERS WITH THE SAME USERNAME
 
 ob_start();
if(strpos($_SERVER['HTTP_USER_AGENT'],'Mediapartners-Google') !== false) {
    exit();
}

  $username = $_POST['username'];
  $link = mysqli_connect("localhost", "root", "root", "login");
  
  
  if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
$sql_check = mysqli_query($link,"select * from `users` where username='$username'");
$num_rows=mysqli_num_rows($sql_check);
if($num_rows==0) {
    $output = 'nothing';
    echo $output;

}   
if($num_rows>0) {
    $output = 'something';
    echo $output;

}   



?>

