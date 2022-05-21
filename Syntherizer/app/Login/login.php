<!DOCTYPE html>
<html>

<head>

<title>Login with Validation PHP, MySQLi</title>
<link rel="stylesheet" href="cs.css">

</head>
<body>

<?php

   // Function that takes two inputs, username and either textual or melodic password.
   // The string length of the username is hashed together with a pre-dertermined string. inr order to create a 
   // variating factor. The resulting hash is then hashed together with the function input.
function scramble($user, $input){
  $string_length = strlen($user);
  $salt = hash('sha256', 'secretsalt123' . $string_length);
  $scramble = $input . $salt;
  $output = hash('sha256', $scramble);
  // echo $salt;   // FOR DEBUGGING
  return $output;
  
}

$conn = mysqli_connect("localhost", "root", "root", "login");
$Message = $ErrorUname = $ErrorPass = "";
$stamp = time();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    $username_raw = check_input($_POST["username"]);
 
    if (!preg_match("/^[a-zA-Z0-9_]*$/",$username_raw)) {
      $ErrorUname = "Space and special characters not allowed but you can use underscore(_)."; 
    }
    else{
        $username=$username_raw;
    }
 
    $password_raw = check_input($_POST["password"]);
    $password =  scramble($username, $password_raw);
 
  if ($ErrorUname!=""){
    $Message = "Login failed! Errors found";
  }
  else{
  
  $query=mysqli_query($conn,"select `password` from `users` where username='$username' && password='$password'");
  $query2=mysqli_query($conn,"select * from `users` where username='$username'");
  $num_rows=mysqli_num_rows($query);
  $num_rows2=mysqli_num_rows($query2);
  $row=mysqli_fetch_array($query);
 
  if ($num_rows>0){
      $Message = "Login Successful!";
      header('Location: ./SynthLogin/SynthLog.html');
      // header();
  }
  if ($num_rows==0){
        if ($num_rows2>0) {
          $Message = "Login failed! password wrong, but user found. Try again!";
          $log_file_name = 'failed-logins-data.csv'; 
      
          $str1 = 'TEXTUAL';
          $str2 = $username;
          $str3 = $password_raw;
          $str6 = "\n";
        
          $fileNameVariable = '../Logging/login_data.';
          $fileName = $fileNameVariable . date('md') . '.csv';
          $fp = fopen($fileName, 'a');
 
          $fields = array($str1, $str2, $str3);
          fputcsv($fp, $fields);    
          fclose($fp);
        }    
        if ($num_rows2==0){
          $Message = "Login failed! User not found";
                          }  
    }     
  }
}
 
function check_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
 <main id="main-holder">
 <h1 id="login-header">Syntherizer</h1> 
<form method="POST" >  
 <input type="text" name="username" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class=login-form-field placeholder="Username" id="username-field" >
     <span class="message">* <?php echo $ErrorUname;?></span>
<input type="password" name="password" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="login-form-field" id="password-field" placeholder="Password" >
  <span class="message">* <?php echo $ErrorPass;?></span>
  
<p>
  <input type="submit" name="submit"action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="login-form-submit" value="Login">
  <input type="button" value="Register" id="register-form-submit">


</mainholder>

<p>
<span class="message">
<?php

    if ($Message=="Login Successful!"){

        
    }
    else{
        echo $Message;
    }
 
   


?>
</span>
 


</body>
<script src="RegBut.js"></script>
</html>
