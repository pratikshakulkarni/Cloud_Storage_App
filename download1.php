<?php 
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


echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"styleUp.css\">";
echo "<title> Student </title>";
echo "<center><h1><font face=\"Kaushan Script\">Welcome Student</br></font></h1></center>";
echo "<div class=\"uploadbox\">";
echo "<center><h2>Download File</h2></center>";
$resource = opendir("uploads/");
$dir = "uploads/";
while (($entry = readdir($resource)) !== FALSE) {
  # code...
  if($entry == "." || $entry == ".." || $entry == "desktop.ini")
    continue;

//echo $entry;
//file handling
$f = fopen($dir.$entry, "r+");
if($f == false)
{
	echo "error";
	exit();
}
$ftext = fread($f, filesize($dir.$entry));
fclose($f);

$arr = preg_split('/\==/', $ftext);
//print_r($arr);
$handle = fopen($dir.$entry,'w') or die('Cannot open file:  '.$entry);
// $enc = encrypt_decrypt('decrypt', $ftext);
// echo $enc;
// fwrite($handle, $enc);

      foreach($arr as $pt)
      {
      	//echo "in";
        $enc = encrypt_decrypt('decrypt', $pt);
        //str_ireplace($pt, $enc, $ftext);
        //echo $enc;
        fwrite($handle, $enc);
        
      }



//stop here
  echo "<a href = \"down.php?file=$entry\">".$entry."<br>";
  
}

echo "<center><p><a href=\"index.html\">Logout</a></center>";
 ?>