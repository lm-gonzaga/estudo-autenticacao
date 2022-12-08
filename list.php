<?php
$path = "./photos/";

foreach (new DirectoryIterator($path) as $fileInfo) {
    if ($fileInfo->isDot()) continue;
	$arquivo = $fileInfo->getFilename();    
	echo "<b>Nome do arquivo: </b>".$arquivo."<br>";
	echo '<a href=https://loki.iriustech.com/upload/photos/'.$arquivo.'>'.$arquivo.'</a><br>';
}

?>