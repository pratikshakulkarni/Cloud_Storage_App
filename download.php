<?php

//include_once("C:/xampp/htdocs/moodle/uploads");

function encrypt_decrypt($action, $string) {
  //echo "in";
    $output = false;

    $encrypt_method = "AES-256-CBC";
    $secret_key = 'This is my secret key';
    $secret_iv = 'This is my secret iv';

    // hash
    $key = hash('sha256', $secret_key);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if ( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, $iv);
        $output = base64_encode($output);
    }else if( $action == 'decrypt' ) {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, $iv);
    } 
    

    return $output;
}


		$dir = "uploads/";

// Open a directory, and read its contents
if (is_dir($dir)){
	//echo "hello";
  if ($dh = opendir($dir)){
    while (($file = readdir($dh)) !== false){
      //echo "filename:.$file. "<br>";

      //FH
      //echo .$file.;
      if($file == "." || $file == ".." || $file == "desktop.ini")
        continue;
      $f = fopen($dir.$file, "r+");
      if($f==false){
      echo "error";
      exit();
      }

      $ftext = fread($f, filesize($dir.$file));
      fclose($f);

      $arr = preg_split('/[\s]+/', $ftext);
      print_r($arr);
      $handle = fopen($dir.$file,'w') or die('Cannot open file:  '.$file);

      foreach($arr as $pt)
      {
        $enc = encrypt_decrypt('decrypt', $pt);
        //str_ireplace($pt, $enc, $ftext);
        echo $enc;
        fwrite($handle, $enc);
        
      }


	   echo "<a href =\"uploads/$file\" download>.$file .</a><br>";
	  //echo "<a download = \"\">.$file</a>";
	  //echo "";
    }
    closedir($dh);
  }
}


?>


