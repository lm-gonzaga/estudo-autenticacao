<?php
session_start();

include_once "connect.php";

//$idUser = $_SESSION['iduser'];
$idUser = $_POST['iduser'];


$conn = new mysqli($host, $usuario, $senha , $db) or die('Não foi possível conectar');
$sqlFind = "SELECT * FROM user WHERE iduser = '$idUser'";
$resFind = $conn->query($sqlFind);
$rowFind = $resFind->fetch_array();
$idUser = $rowFind['iduser'];
$name = $rowFind['name'];
$email = $rowFind['email'];


$message = ''; 
if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'Upload')
{
    
  if (isset($_FILES['uploadedFile']))
  {

      if( $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK)
  {
    
    $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
    $fileName = $_FILES['uploadedFile']['name'];
    $fileSize = $_FILES['uploadedFile']['size'];
    $fileType = $_FILES['uploadedFile']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));
    
    // sanitize file-name
    $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
 	//$newFileName = "profile" . '.' . $fileExtension;
    // VERIFICAR SE O ARQUIVO ESTÁ NAS EXTENSÕES PEMITIDAS, MANTE SOMENTE JPG/GIF/PNG
    $allowedfileExtensions = array('jpg', 'gif', 'png');
 
    if (in_array($fileExtension, $allowedfileExtensions))
    {
      // DIRETÓRIO PARA QUAL SERÁ MOVIDO/SALVO O ARQUIVO FINAL DE IMAGEM
      $uploadFileDir = './photos/';
      $dest_path = $uploadFileDir . $newFileName;
  		
      if(move_uploaded_file($fileTmpPath, $dest_path)) 
      {
        $message ='File is successfully uploaded.';
        $tmp = explode('.',$dest_path);
        $newfileCroped = $tmp[1].'-croped.'.$tmp[2]; 
		$filetoResize = '.'.$newfileCroped;            	
      	$newfileResized = $tmp[1].'-resized.png'; 
        
        crop($dest_path,$newfileCroped);

        resize($filetoResize,$newfileResized);
      
      	$queryUp = "UPDATE user SET url_photo ='$newfileResized' WHERE `iduser` = '$idUser' ;";
        $sqlUp = $conn->query($queryUp);
      	$nRowUP = mysqli_affected_rows($conn);
        if($nRowUP == 1){
          //header('Location: userProfile.php');
          	$dados = array(
            		'photo' => $newfileResized,
            		'iduser' => $rowFind['iduser'],
        			'name'=>$name,
        			'email'=>$email
    		);

			$data[]=$dados;

    		$resposta = json_encode(
        		(object)array(
            		'response' => 'updated data',
        			'code' => '200',
        			'data'=>$data
        			)
        		);	
	
    		error_log($resposta);
    		echo ($resposta);
        }
      
        
      } /*============== FIM DO IF DA LINHA 31 ==============*/
      else
      {
        $message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
      }
    }
    else
    {
      $message = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
    }
  }//fechamento da 12
  else
  {
    $message = 'There is some error in the file upload error is not set. Please check the following error.<br>';
    $message .= 'Error:' . $_FILES['uploadedFile']['error'];
  	//echo 'Error:' . $_FILES['uploadedFile']['error'];
  }
  } //fechamento da linha 10  
	else{
  $message = 'There is some error in the file upload file is not set. Please check the following error.<br>';
    $message .= 'Error:' . $_FILES['uploadedFile']['error'];
    error_log('Erro customizado' . PHP_EOL, 3, '/home/usuario/meulogdeerror.log');
  	}
}
//$_SESSION['message'] = $message;



function crop($entrada,$saida){  
  //Your Image

  $imgSrc = $entrada;  
  //getting the image dimensions
  list($width, $height,$tipo) = getimagesize($imgSrc);  
  //saving the image into memory (for manipulation with GD Library)
  switch($tipo){
    case 1:
      
      $myImage = imagecreatefromgif($imgSrc);
      break;
    case 2:
      $myImage = imagecreatefromjpeg($imgSrc);
  	  
      break;      
    case 3:
      
      $myImage = imagecreatefrompng($imgSrc);
      break;
  }

  // calculating the part of the image to use for thumbnail
  if ($width > $height) {
    $y = 0;
    $x = ($width - $height) / 2;
    $smallestSide = $height;
  } else {
    $x = 0;
    $y = ($height - $width) / 2;
    $smallestSide = $width;
  }
  
  // copying the part into thumbnail
  $thumbSize = 300;
  $thumb = imagecreatetruecolor($thumbSize, $thumbSize);
  imagecopyresampled($thumb, $myImage, 0, 0, $x, $y, $thumbSize, $thumbSize, $smallestSide, $smallestSide);
  
  //final output	
  imagepng($thumb, ".".$saida, 9);
    
}


function resize($entrada,$saida){
  $width = 200;
  $height = 200;
  list($width_orig, $height_orig, $tipo) = getimagesize($entrada);
	//echo "<br>(linha 112)var dump do entrada: ";var_dump($entrada);
  $ratio_orig = $width_orig/$height_orig;

  if ($width/$height > $ratio_orig) {
      $width = $height*$ratio_orig;
  } else {
    $height = $width/$ratio_orig;
  }

  switch($tipo){
    case 1:
      
      $image_p = imagecreatetruecolor($width, $height);
      $image = imagecreatefromgif($entrada);
      imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
      imagepng($image_p, ".".$saida, 9);
      break;

    case 2:
      
      $image_p = imagecreatetruecolor($width, $height);
      $image = imagecreatefromjpeg($entrada);
      imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);  	  
      imagepng($image_p, ".".$saida, 9);
      break;
              
    case 3:
      
      $image_p = imagecreatetruecolor($width, $height);
      $image = imagecreatefrompng($entrada);
      imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
      imagepng($image_p, ".".$saida, 9);
      break;       
  }
  imagedestroy($image);
  imagedestroy($image_p);
}

?>