 <?php
   
   
   
function scramble($user, $input){
   // Function that takes two inputs, username and either textual or melodic password.
   // The string length of the username is hashed together with a pre-dertermined string. inr order to create a 
   // variating factor. The resulting hash is then hashed together with the function input.
  $string_length = strlen($user);
  $salt = hash('sha256', 'secretsalt123' . $string_length);
  $scramble = $input . $salt;
  $output = hash('sha256', $scramble);
  // echo $salt;   // FOR DEBUGGING
  return $output;
  
}
   
  $username = $_POST['username'];
  $synthpas_raw = $_POST['cleaned'];
  $synthpas =  scramble($username, $synthpas_raw);
  $stamp = time();
  $link = mysqli_connect("localhost", "root", "root", "login");
  $array_to_string = strval($synthpas_raw);

  // Exception handler for connection errors
  if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// CHECKS DATABASE TO SEE IF THE SYNTH OUTPUT OF THE HASHED SYNTH INPUT IS THE SAME AS THE STORED SYNTH PASSWORD FOR
// THE ENTERED USERNAME 
  $query=mysqli_query($link,"select `password` from `users` where username='$username' && synth='$synthpas'");
  $query2=mysqli_query($link,"select * from `users` where username='$username'");
  $num_rows=mysqli_num_rows($query);
  $num_rows2=mysqli_num_rows($query2);
  $row=mysqli_fetch_array($query);
 
  // IF THE NUMBER OF ROWS ARE MORE THAN 0, ECHO 'Correct' WHICH WILL BE CAUGHT IN script.js BY AJAX.
  // BECAUSE DUPLICATE USERNAMES ARE NOT ALLOWED, NO MORE THAN 1 ROW CAN BE SHOWN.
  if ($num_rows>0){
      $Output = "Correct";
      echo $Output;
      // header('Location: ../login.php');
 
  }
  // IF THE NUMBER OF ROWS IS EQUAL TO 0, QUERY DATABASE TO SEE IF USERNAME EXISTS. IF NUMBER OF ROWS RETURNED ARE 
  // MORE THAN 0, USERNAME MUST EXIST, AND MELODY MUST BE WRONG. LOG AS FAILED LOGIN TO CSV.
  // ECHO 'NoPas' WHICH WILL BE CAUGH BY AJAX IN script.js
  // IF USERNAME DOES NOT EXIST, ECHO 'NoUser' WHICH WILL BE CAUGH BY AJAX IN script.js
  if ($num_rows==0){
        if ($num_rows2>0) {
          
          // $log_file_name = 'failed-logins-data.csv';
          
          $str1 = 'MELODY';
          $str2 = $username;
          $str3 = str_replace('"', "", $array_to_string);
          $str6 = "\n";
        

          $fileNameVariable = '../../Logging/login_data.';
          $fileName = $fileNameVariable . date('md') . '.csv';
          $fp = fopen($fileName, 'a');
          $fields = array($str1, $str2, $str3);
          fputcsv($fp, $fields);
          fclose($fp);
          $Output = "NoPas";
          echo $Output;

        }    

        if ($num_rows2==0){
          $Output = "NoUser";
          echo $Output;
          
                          }
      
    }
      
  


// mysqli_close($link);


?>


