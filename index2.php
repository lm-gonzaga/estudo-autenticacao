<?php
session_start(); 
?>
<!DOCTYPE html>
<html>
<head>
  <title>PHP File Upload</title>
</head>
<body>
  <?php
    if (isset($_SESSION['message']) && $_SESSION['message'])
    {
      echo '<p class="notification">'.$_SESSION['message'].'</p>';
      unset($_SESSION['message']);
    }
  ?>
  <form method="POST" action="upload.php" enctype="multipart/form-data">
    <div class="upload-wrapper">
      <span class="file-name">Choose a file...</span>
      <label for="file-upload">Browse<input type="file" id="file-upload" name="uploadedFile"></label>
    </div>
 
    <input type="submit" name="uploadBtn" value="Upload" />
  </form>
  <div>
      <h3>Lista de arquivos</h3>
  	<?php include_once "list.php";     ?>	
  </div>
</body>
</html>