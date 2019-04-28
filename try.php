<?php

		$dir = "uploads/";

// Open a directory, and read its contents
if (is_dir($dir)){
	echo "hello";
  if ($dh = opendir($dir)){
    while (($file = readdir($dh)) !== false){
      //echo "filename:".$file. "<br>";
      if($file == "." || $file == "..")
        continue;
      echo "chaeck" .$file. "<br>";
      //echo readdir($dh);
	 // echo "<a href =\"uploads/$file\" download>.$file .</a><br>";
	  //echo "<a download = \"\">.$file</a>";
	  //echo "";
    }
    closedir($dh);
  }
}


?>


