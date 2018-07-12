<?php
 if(isset($_GET['phone_number'])){
     if($_GET['phone_number']==927141028){
         $info=['name'=>"Dilmurod",'second_name'=>"Toshmatov","adress"=>"ISfara","email"=>"dilmurod_0594@mail.ru"];
         echo json_encode($info);
     }
 }