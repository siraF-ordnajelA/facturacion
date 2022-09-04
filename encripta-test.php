<?php

   $pass = '1234';
   $passHash = password_hash($pass, PASSWORD_BCRYPT);
   echo $passHash . '<br><br>';
   
   if (password_verify($pass, $passHash)) {
    echo 'Password is valid!';
    echo '<br><br>';
    echo 'Pass: '.$pass.'<br>';
    echo 'Hash: '.$passHash;
   } else {
       echo 'Invalid password.';
       echo '<br><br>';
      echo 'Pass: '.$pass.'<br>';
      echo 'Hash: '.$passHash;
   }
?>