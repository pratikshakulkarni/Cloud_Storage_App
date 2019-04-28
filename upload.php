<?php
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"styleUp.css\">";
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

if(isset($_POST['submit']))
{

	//echo "pressed";
	$file_name = $_FILES['file']['name'];
	$file_type = $_FILES['file']['type'];
	$file_size = $_FILES['file']['size'];
	$file_temp_loc = $_FILES['file']['tmp_name'];

	$file_store = "uploads/".$file_name;
	//echo $file_type;

	// if($file_type != "text/plain" || $file_type != "txt" || $file_type != "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
	// {
	// 	echo "Sorry only .txt or .docx allowed";
	// }

	if(file_exists($file_name))
	{
		echo "File already exists";
	}

	//file handling starts here
	$f = fopen($file_temp_loc, "r+");
	if($f==false){
		echo "error";
		exit();
	}

	$ftext = fread($f, $file_size);
	fclose($f);

	$arr = preg_split('/[\s]+/', $ftext);
	$handle = fopen($file_temp_loc,'w') or die('Cannot open file:  '.$file_temp_loc);
	foreach($arr as $pt)
	{
		$enc = encrypt_decrypt('encrypt', $pt);
		//str_ireplace($pt, $enc, $ftext);
		//echo $enc;
		fwrite($handle, $enc);
		
	}


	if(move_uploaded_file($file_temp_loc, $file_store))
	{
		//echo "File Uploaded";
		echo "<center><h1><font face=\"Kaushan Script\">File Uploaded</br></font></h1></center>";
		//header("location: upload.html");
	}



}




?>