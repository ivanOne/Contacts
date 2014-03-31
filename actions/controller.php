<?php
include '../model.php';
 $action= new Contacts;
 switch ($_GET['cmd']){
     case "addContact":
         $action->addContact();
     break;
     case "recordContact":
         $action->recordContact();
     break;
     case "deleteContact":
         $action->deleteContact();
     break;
     case "editGroupList":
         $action->editGroupList();
     break;
     case "addGroupList":
         $action->addGroupList();
     break;
     case "delGroupList":
         $action->delGroupList();
     break;
     case "addNumList":
         $action->addNumList();
     break;
     case "delNumList":
         $action->delNumList();
     break;
     case "updateNum":
         $action->updateNum();
     break;
     case "addGroup":
         $action->addGroup();
     break;
     case "delGroup":
         $action->delGroup();
     break;
     case "more":
         $action->more();
     break;
     
 }
?>