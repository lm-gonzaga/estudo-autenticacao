<?php
include_once "connect.php";

$conn = new mysqli($host, $usuario, $senha, $db) or die('Não foi possível conectar');

$sql = "SELECT * FROM user";
$result = $conn->query($sql);
?>

<table cellpadding="0" cellspacing="0" border="2" class="table table-striped">
	<thead>
		<tr>
        	<th>ID</th>
            <th>NAME</th>
            <th>EMAIL</th>                
            <th>URL_PHOTO</th>
			<th>PHOTO</th>
        </tr>
    </thead>
    <tbody>
    	<?php while ($row = $result->fetch_array()) { ?>
        	<tr>
            	<td><?php echo $row['iduser']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['email']; ?></td>                    
                <td><?php echo $row['url_photo']; ?></td>
            	<td><img src=".<?php echo $row['url_photo']?>" alt=""></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
