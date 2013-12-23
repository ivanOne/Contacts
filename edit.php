<?php
include 'actions/model.php';
$result= new Contacts;
?>
<!Doctype html>
<html>
    <head>
    <meta charset="utf-8">
    <title>Группы</title>
    <link type="text/css" href="css/style.css" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>  
    <script src="js/jquery.maskedinput.min.js" type="text/javascript"></script>
    <script src="js/myScript.js" type="text/javascript"></script>
    </head>
    <body>
    <a href='index.php'>К списку контактов</a>
    <div id="editcont">
    <?php
    echo "<button id='updatename'>Обновить ФИО</button>";
    	$result->edit();
    ?>
   	
	</div>
    </body>
</html>