<?php
/*----------блок вывода списка работников--------------------------*/
  if ($_POST["fioText"]!="") {
    $file=file_get_contents('setFio.json');
    unset($file);
    file_put_contents('setFio.json',json_encode($_POST["fioText"],JSON_UNESCAPED_UNICODE));
  //  echo "Мы выбрали: ".$_POST["fioText"];
  }

/*------------------------------------------------------------------*/
  /*--------------блок обработки данных отпуска-----------------------------*/
      if ($_POST["ourData"]!=NULL) {
     $result=json_decode($_POST["ourData"]);
     echo "vacationStart=".$result->vacationStart;
     echo "vacationEnd=".$result->vacationEnd;
   }
    /*--------------блок обработки данных отпуска-----------------------------*/
    
?>