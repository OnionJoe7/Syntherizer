

<?php

 ob_start();
if(strpos($_SERVER['HTTP_USER_AGENT'],'Mediapartners-Google') !== false) {
    exit();
 }


   // Function that takes two inputs, username and either textual or melodic password.
   // The string length of the username is hashed together with a pre-dertermined string. inr order to create a 
   // variating factor. The resulting hash is then hashed together with the function input.
function scramble($user, $input){
  $string_length = strlen($user);
  $salt = hash('sha256', 'secretsalt123' . $string_length);
  $scramble = $input . $salt;
  $output = hash('sha256', $scramble);
  echo $salt;   // FOR DEBUGGING
  return $output;
  
}
    // $password =  hash('sha256', $password_raw);     // FOR DEBUGGING

  $username = $_POST['username'];
  $password_raw = $_POST['password'];
    $password  = scramble($username, $password_raw);
  $synthpas_raw = $_POST['cleaned'];
    $synthpas =  scramble($username, $synthpas_raw);
  $link = mysqli_connect("localhost", "root", "root", "login");
  
  
mysqli_query($link, $sql = "INSERT INTO users VALUES ('NULL','$username', '$password' ,'$synthpas')");
mysqli_close($link);
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
    }


?>

