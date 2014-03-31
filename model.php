<?php
class Contacts{
    private $host="localhost";
    private $user="root";
    private $password="";
    private $database="contacts";

    public $queryCont="SELECT contact.id_name, contact.name, contact.s_name, contact.m_name, number.telephone, (
    COUNT( contact.id_name ) >1
    ) AS counter
    FROM contact
    LEFT JOIN number ON contact.id_name = number.id_name
    GROUP BY id_name";

    public $queryGroup="SELECT id_group, group_name FROM groups";
    public $lastStringGroup="SELECT id_group, group_name FROM groups ORDER BY id_group DESC LIMIT 1";

    function getContacts(){
        if($link=mysql_connect($this->host,$this->user,$this->password)){ 
            mysql_select_db($this->database);       
            $res=mysql_query($this->queryCont) or die(mysql_error());
            while ($t = mysql_fetch_array($res, MYSQL_ASSOC)) {
                echo "<div class='item' id='it".$t['id_name']."'><div class='nameWrap'><p>".$t['s_name']."</p><p>".$t['name']."</p><p>".$t['m_name']."</p></div>";
                echo "<div class='groupsWrap'><p>Группа</p>";
                $groups=mysql_query("SELECT groups.group_name FROM groups 
                left JOIN cont_groups ON groups.id_group=cont_groups.id_group WHERE id_name='".$t['id_name']."'")or die(mysql_error());
                while ($g=mysql_fetch_array($groups, MYSQL_ASSOC)) {
                    echo "<p>".$g['group_name']."</p>";      
                }
                echo "</div>";
                echo "<div class='numWrap'>";
                echo "<p id='tel".$t['id_name']."'>".$t['telephone']."</p>";
                
                //проверка на наличие других номеров у контакта
                if ($t['counter']==='1') { 
                  echo "<span id='fade".$t['id_name']."'><button class='more' id='".$t['id_name']."'>Все номера</button></span>";
                }
                echo "</div>";
                echo "<div class='delEdit'><a href=edit.php?id=".$t['id_name']."><button>Редактировать</button></a></br>
                      <button class='delete' id='".$t['id_name']."'>Удалить</button></div></div>";

            }
           
            mysql_close($link);
        }

        else{
           die('Ошибка соединения');
        }
    }

    function getGroup(){
        if($link=mysql_connect($this->host,$this->user,$this->password)){ 
            mysql_select_db($this->database);       
            $res=mysql_query($this->queryGroup) or die(mysql_error());
            mysql_close($link);
            return $res;
        }
        else{
           die('Ошибка соединения');
        }
    }

    function addGroup(){
        if(isset($_GET['data'])){
            $data=$_GET['data'];
            if($link=mysql_connect($this->host,$this->user,$this->password)){
                mysql_select_db($this->database);
                mysql_query("INSERT INTO groups SET `group_name`='$data'");
                $res=mysql_query($this->lastStringGroup);
                mysql_close($link);
                $string=mysql_fetch_array($res, MYSQL_ASSOC);
                echo "<div id=".'c'.$string['id_group']."><p>".$string['group_name']."</p> 
        <button class='del' id=".$string['id_group'].">Уудалить группу</button></div>";
            }
            else{
                die('Ошибка соединения');
        }
    }
    }

    function delGroup(){
        if($_GET){
            $data=$_GET['id'];
            if($link=mysql_connect($this->host,$this->user,$this->password)){
                mysql_select_db($this->database);
                mysql_query("DELETE FROM `groups` WHERE `id_group`='$data'");
                mysql_close($link);
            }
            else{
                die('Ошибка соединения');
            }
        }
    }
    function more(){
        if($_GET){
            $data=$_GET['id'];
            if($link=mysql_connect($this->host,$this->user,$this->password)){
                mysql_select_db($this->database);
                $res=mysql_query("SELECT telephone FROM `number` WHERE id_name ='$data'")or die(mysql_error());
                mysql_close($link);
                while($tel=mysql_fetch_array($res, MYSQL_ASSOC)){
                echo "<p>".$tel['telephone']."</p>";
                }
            }
            else{
                die('Ошибка соединения');
            }
        }
    }
    function addContact(){
            if($link=mysql_connect($this->host,$this->user,$this->password)){
                mysql_select_db($this->database);
                $res=mysql_query($this->queryGroup)or die(mysql_error());
                mysql_close($link);
                $i=0;
                while ($form=mysql_fetch_array($res, MYSQL_ASSOC)) {
                    echo "<input type='checkbox' name='group[".$i."]' value='".$form['id_group']."'/>".$form['group_name']."</br>";
                    $i++;        
                }
            }
            else{
                die('Ошибка соединения');
                }
            
    }

    function recordContact(){
            $name=$_GET['name'];
            $name1=$_GET['name2'];
            $name2=$_GET['name3'];
            $number=$_GET['num'];
            $group=$_GET['group'];
            $numplus=$_GET['numplus'];
            if($link=mysql_connect($this->host,$this->user,$this->password)){
                mysql_select_db($this->database);
                mysql_query("INSERT INTO contact(name,s_name,m_name) VALUES('$name','$name1','$name2')")or die(mysql_error());
                mysql_query("INSERT INTO number(id_name, telephone) values ((SELECT id_name FROM contact ORDER BY id_name DESC LIMIT 1),'$number')")or die(mysql_error());
                if (isset($group)) {
                    foreach ($group as $value) {
                        mysql_query("INSERT INTO cont_groups(id_name, id_group) VALUES((SELECT id_name FROM contact ORDER BY id_name DESC LIMIT 1),'$value')")or die(mysql_error());
                    }
                }
                if(isset($numplus)){
                    foreach ($numplus as $value) {
                        mysql_query("INSERT INTO number(id_name,telephone) VALUES((SELECT id_name FROM contact ORDER BY id_name DESC LIMIT 1),'$value')")or die(mysql_error());
                    }
                }
                $res=mysql_query("SELECT contact.id_name, contact.name, contact.s_name, contact.m_name, number.telephone, (
                                COUNT( contact.id_name ) >1
                                ) AS counter
                                FROM contact
                                INNER JOIN number ON contact.id_name = number.id_name
                                GROUP BY id_name desc limit 1");
                $r=mysql_fetch_array($res, MYSQL_ASSOC); 
                echo "<div class='item' id='it".$r['id_name']."'><div class='nameWrap'><p>".$r['s_name']."</p>
                <p>".$r['name']."</p>
                <p>".$r['m_name']."</p></div>";
                $groups=mysql_query("SELECT groups.group_name FROM groups 
                left JOIN cont_groups ON groups.id_group=cont_groups.id_group WHERE id_name='".$r['id_name']."'")or die(mysql_error());
                echo "<div class='groupsWrap'>";
                while ($g=mysql_fetch_array($groups, MYSQL_ASSOC)) {
                    echo "<p>".$g['group_name']."</p>";      
                }
                echo "</div>";
                echo "<div class='numWrap'>";
                echo "<p id='tel".$r['id_name']."'>".$r['telephone']."</p>";
                
                //проверка на наличие других номеров у контакта
                if ($r['counter']==='1') { 
                  echo "<span id='fade".$r['id_name']."'><button class='more' id='".$r['id_name']."'>еще</button></span>";
                }
                echo "</div>";
                
                echo "<div class=delEdit>";
                 echo "<a href=edit.php?id=".$r['id_name']."><button>Редактировать</button></a>
                      <button class='delete' id='".$r['id_name']."'>Удалить</button></div>";
                echo "</div>";
                mysql_close($link);
            }else{
                die('Ошибка соединения');
                }


    }
    function edit(){
        $i=0;
        $id=$_GET['id'];
            if($link=mysql_connect($this->host,$this->user,$this->password)){
                mysql_select_db($this->database);
                $name=mysql_query("SELECT name, s_name, m_name from contact where
                id_name ='$id'");
                $number=mysql_query("SELECT telephone, id_phone from number where id_name='$id'");
                $group=mysql_query("SELECT groups.group_name, cont_groups.id_group  FROM groups 
                left JOIN cont_groups ON groups.id_group=cont_groups.id_group WHERE id_name='$id'");
                $resultName=mysql_fetch_array($name,MYSQL_ASSOC);
                mysql_close($link);
                echo "<input hidden class='inf' name='id' value=".$id."><input class='letter' id='name' name='name' value='".$resultName['name']."'>
              <input class='letter' id='name2' name='name2' value='".$resultName['s_name']."'>
              <input class='letter' id='name3' name='name3' value='".$resultName['m_name']."' >";
              echo "<div class=numberWrap><p>Номера телефонов</p>";
              while ($resultNumbers=mysql_fetch_array($number,MYSQL_ASSOC)) {
                  echo "<div class='itemnum' id=d".$resultNumbers['id_phone']."><input id=t".$resultNumbers['id_phone']." class='number' name='[".$i."]' value='".$resultNumbers['telephone']."'><button class='delList' id='".$resultNumbers['id_phone']."'>Удалить</button>
                  <button class='updatenum' id=".$resultNumbers['id_phone'].">Обновить</button></div>";
                  $i++;
              }
              echo "</div><button id='plus'>Добавить номера</button><button id='deleteBut' style='visibility:hidden'>Удалить</button>
              <button id='save' style='visibility:hidden'>Записать новые номера</button>";
              echo "<div class='groups'><p>Группы</p>";
              while ($resultGroups=mysql_fetch_array($group,MYSQL_ASSOC)) {
                    echo "<div class=itemGroup id=".$resultGroups['id_group'].">";
                  echo "<input class='query' style='visibility:hidden' name='id[".$c."]' value=".$resultGroups['id_group']."><p>".$resultGroups['group_name']."</p>
                  <button  id=".$resultGroups['id_group']." class='edGroup'>Удалить</button></div>";
                    $c++;            
            }   
            echo "</div>"; 
            echo "<div class='list'></div>";                     
            echo "<button id='addList'>Добавить</button>";
            }else{ 
                die('Ошибка соединения');
            }
                 
    }
   function editGroupList(){
        $data=$_GET['id'];
        if($link=mysql_connect($this->host,$this->user,$this->password)){
                mysql_select_db($this->database);
                $group=mysql_query($this->queryGroup);
                while ($g=mysql_fetch_array($group,MYSQL_ASSOC)) {
                      if (!(@in_array($g['id_group'], $data))){
                        echo "<div class='addList'><p>".$g['group_name']."<button id=".$g['id_group']." class='addGroupList'>Добавить</button></div>";
                      }
                }
                
                mysql_close($link);
        }else{ 
                die('Ошибка соединения');
            }

    }
    function addGroupList(){
        $data=$_GET['id'];
        $data1=$_GET['idcon'];
        if($link=mysql_connect($this->host,$this->user,$this->password)){
                mysql_select_db($this->database);
                $group=mysql_query("INSERT INTO cont_groups(id_name,id_group) VALUES ('$data1','$data')")or die(mysql_error());
                if($group){
                     $groupList=mysql_query("SELECT groups.group_name, cont_groups.id_group  FROM groups 
                INNER JOIN cont_groups ON groups.id_group=cont_groups.id_group GROUP BY id DESC LIMIT 1")or die(mysql_error());
                     $res=mysql_fetch_array($groupList,MYSQL_ASSOC);
                     echo "<div class=itemGroup id=".$res['id_group'].">";
                  echo "<input class='query' style='visibility:hidden' name='id[".$c."]' value=".$res['id_group']."><p>".$res['group_name']."</p>
                  <button class='edGroup' id=".$res['id_group'].">Удалить</button></div>";        
            }   
                
                
                mysql_close($link);
        }else{ 
                die('Ошибка соединения');
            }

    }

    function delGroupList(){
        $data=$_GET['id'];
        $data1=$_GET['idcon'];
            if($link=mysql_connect($this->host,$this->user,$this->password)){
                mysql_select_db($this->database);
                mysql_query("DELETE FROM cont_groups where id_name='$data1' and id_group='$data'")or die(mysql_error()); 
                mysql_close($link);
            }else{ 
                die('Ошибка соединения');
            }
           
    }

    function addNumList(){
        $data=$_GET['num'];
        $data1=$_GET['idcont'];
        $limit=count($data);
        if($link=mysql_connect($this->host,$this->user,$this->password)){
                mysql_select_db($this->database);
                foreach ($data as $value) {
                    $num=mysql_query("INSERT INTO number(id_name,telephone) VALUES ('$data1','$value')")or die(mysql_error());
                }
                
                $lastNum=mysql_query("SELECT id_phone, telephone FROM number ORDER BY id_phone DESC LIMIT ".$limit."")or die(mysql_error());
                while($resultNumbers=mysql_fetch_array($lastNum, MYSQL_ASSOC)){
                echo "<div class='itemnum' id=d".$resultNumbers['id_phone']."><input class='number' id=t".$resultNumbers['id_phone']." name='[".$i."]' value='".$resultNumbers['telephone']."'>
                <button class='delList' id='".$resultNumbers['id_phone']."'>Удалить</button><button class='updatenum' id='".$resultNumbers['id_phone']."'>Обновить</button></div>";
                }
                mysql_close($link);
            }else{ 
                die('Ошибка соединения');
            }
            
        
    }                
    function updateNum(){
        $id=$_GET['id'];
        $number=$_GET['tel'];
        if($link=mysql_connect($this->host,$this->user,$this->password)){
                mysql_select_db($this->database);
                mysql_query("UPDATE number SET telephone='$number' WHERE id_phone='$id'");
                mysql_close($link);

        }else{ 
            die('Ошибка соединения');
            }
}
    function deleteContact(){
        $id=$_GET['id'];
        if($link=mysql_connect($this->host,$this->user,$this->password)){
            mysql_select_db($this->database);
            mysql_query("DELETE FROM contact where id_name='$id'");
            mysql_query("DELETE FROM cont_groups where id_name=$id");
            mysql_query("DELETE FROM number where id_name=$id");
            mysql_close($link);
        }else{ 
            die('Ошибка соединения');
            }
    }

    function delNumList(){
        $id=$_GET['id'];
        if($link=mysql_connect($this->host,$this->user,$this->password)){
                mysql_select_db($this->database);
                mysql_query("DELETE FROM number WHERE id_phone='$id'");
                mysql_close($link);
       }else{ 
            die('Ошибка соединения');
            }
    }
    function updateName(){
        $id=$_GET['id'];
        $name=$_GET['name'];
        $sname=$_GET['name2'];
        $mname=$_GET['name3'];
        if($link=mysql_connect($this->host,$this->user,$this->password)){
                mysql_select_db($this->database);
                mysql_query("UPDATE contact SET name='$name', s_name='$sname', m_name='$mname' WHERE id_name='$id'");
                mysql_close($link);
       }else{ 
            die('Ошибка соединения');
            }
    }                
}
