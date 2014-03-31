<?php
	include 'model.php';
	$result= new Contacts;
	$group=$result->getGroup();
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
    </head>
    <body>
    <a href='index.php'>К списку контактов</a>
    <div id="groups">
   	<?php
	while ($t = mysql_fetch_array($group, MYSQL_ASSOC)){
		echo "<div id=".'c'.$t['id_group']."><p>".$t['group_name']."</p></div>";
		echo "<div><button class='del' id=".$t['id_group'].">Уудалить группу</button></div>";}
	?>
	</div>
	<input id='group' type='text'>
	<button id='add'>Добавить группу</button>
    </body>
</html>