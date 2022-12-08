<?php
session_start(); 
?>
<!DOCTYPE html>
<html>
<head>
  <title>PHP File Upload</title>
</head>
<body>
  <form method="POST" action="upload.php" enctype="multipart/form-data">
    <div class="upload-wrapper">
      <span class="file-name">Altere a sua foto de perfil </span>
      <label for="file-upload"><input type="file" id="file-upload" name="uploadedFile"></label>
    </div> 
    <input type="submit" name="uploadBtn" value="Upload" />
  </form>  
</body>
</html>