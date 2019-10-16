<form action="" method="get">
  Search name:<input type="text" name="searchName">
  <input type="submit" value="Submit">
</form>

<form action="" method="get">
<input style="visibility:hidden;width: 0; padding: 0; margin: 0; height: 0;" type="text" name="searchName2" value="<?= $_GET['searchName'] ?>">
  Name you want to replace: <input type="text" name="origin">
  Replace with:             <input type="text" name="replace">
  <input type="submit" value="Submit">
</form> 

<?php 
	$arrayFile = [];
  $returnValue= [];
	$filtedFile = [];
  $dirr =  getcwd();
   if(isset($_GET['searchName'])) {
    $var=$_GET['searchName'];
		$returnValue = checkFileName($dirr, $var);
		filterArray($var);
   }
	 //var_dump($returnValue);

    if(isset($_GET['origin']) && isset($_GET['replace'])) {
        $origin=$_GET['origin'];
        $replacenName=$_GET['replace'];
				$returnValue = checkFileName($dirr, $_GET['searchName2']); 
				filterArray($_GET['searchName2']);
				replaceFile($origin, $replacenName);
       } 
?>

<?php

function checkFileName($dirr, $var) {
    global $arrayFile;
    $tree = glob(rtrim($dirr, '/') . '/*');
    if (is_array($tree)) {
        foreach($tree as $file) {
            if (is_dir($file)) {             
                checkFileName($file, $var);
            } elseif (is_file($file)) {
                //echo $file . '<br/>';
								$arrayFile[] = $file;
								//filterArray($file, $var);
                checkFileName($file,$var);
            }
        }
    }
}

function filterArray($var) {
	global $arrayFile;
	global $filtedFile;
	foreach ($arrayFile as $file1) {
		$fp = fopen($file1, 'r');
		while(false !== ($char = fgets($fp))) {
		if(strpos($char, $var)!==false) {
				$filtedFile[] = $file1;
				echo $file1 . "<br>";
				break;
		}
	}
	fclose($fp);
	}
}

//var_dump($arrayFile);

//

function replaceFile($origin, $replacenName){
    global $filtedFile;
		var_dump($filtedFile);
    foreach($filtedFile as $fname) {
			$arr = [];
			$fp = fopen($fname, 'r');
			if (!$fp) {
				echo 'Could not open file somefile.txt';
			} else {
					while (false !== ($char = fgets($fp))) {
						$arr[] = str_replace($origin, $replacenName, $char);
					}
			}
			fclose($fp);
			$fp = fopen($fname, 'w');
			foreach ($arr as $str) {
				fwrite($fp, $str);
			}
			fclose($fp);
		}
		
		
}
?>
