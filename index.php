<?php
    include 'model.php';
    $result= new Contacts;  
    ?>
<!Doctype html>
<html>
    <head>
    <meta charset="utf-8">
    <title>Страница контактов</title>
    <link type="text/css" href="css/style.css" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>  
    <script src="js/jquery.maskedinput.min.js" type="text/javascript"></script>
    <script src="js/myScript.js" type="text/javascript"></script>
    </head>
    <body>

        <a href='group.php'>Просмотр групп</a>
        <div class='contact'>
        <?php
        $result->getContacts(); 
        ?>
        </div>
        <div id='res'></div>
        <button id='addnum'>Новый контакт</button>
        <div id='form' style="display:none">
            <h2>Заполните поля формы</h2>
            <p>Имя</p>
            <input type='text' id='name' name='name' class='letter'/>
            <p>Фамилия</p>
            <input type='text' id='name2' name='name2' class='letter'/>
            <p>Отчество</p>
            <input type='text' id='name3' name='name3' class='letter'/>
            <p>Группа</p>
            <span id='check'>      
            </span>
            </br>
            <p>Номер телефона</p>
            <span id='moreinput'>
            <input type='text' id='number' name='num' telnum/>
            </span></br>
            <button id='moreinp'>Добавить еще номера</button>
            <button id='delete' style='visibility:hidden'>Удалить номера</button>
            <button id='record'>Записать</button>  
            <button id='cancel'>Отменить</button> 
        </div>
    </body>
</html>