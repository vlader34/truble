<?php
  session_start();
?>
<!DOCTYPE html>
	<html>
	<head> 
		<link  rel="stylesheet" type="text/css" base href="style.css">
   
		<meta http-equiv = "content-type" content = "text/html; charset = utf-8" > 
		<title>Изменение данных работников </title>
		
	</head>
<body>

<?php
$_SESSION['check']=true;
if (!$_SESSION['check'])
{ 
  echo "<p>Вы не авторизированы в системе. У Вас нет прав доступа для внесения изменений в базу данных<br/>"; 
  echo "<a href=\"index.php\">На главную</a></p> <br>"; 
}
else 
 {
 /*создаем список работников и данные скидываем на json файл */
 $file=file_get_contents('worklist.json');
 unset($file);
    $link = mysqli_connect('localhost', 'root', '123', 'watch'); 
      if (!$link) {
          echo "Ошибка подключения к БД. Код ошибки: " . mysqli_connect_error();
          exit;
      } 
    else 
    {   $i=0;
        //$basicArray= array();
        $query=mysqli_query($link,"SELECT `fio`, `id_cheng` FROM `basic` ORDER BY `basic`.`id_cheng` ASC ");
          while ($result = mysqli_fetch_array($query,MYSQLI_ASSOC))
         {
             $name=$result['fio']; $id_cheng=$result['id_cheng'];
             $basicArray[$i]=[$name,$id_cheng]; 
             $i++;
         }
        // print_r($basicArray);
         file_put_contents('worklist.json',json_encode($basicArray,JSON_UNESCAPED_UNICODE));
    }
/*----------------------------------------------------------------------------------*/

?>
<script type="text/javascript">
/*----------вывод работников по списку---------------*/
/*-----------и ивыбор из их числа -------------------*/
   //------делаем ajах запрос на получие списка работников -----------//
     var workerDiv=document.createElement('div'); 
     var ajaxRequest=new XMLHttpRequest();
     ajaxRequest.open('GET','worklist.json',true);
      ajaxRequest.overrideMimeType("application/json");
     ajaxRequest.setRequestHeader('Content-type','application/x-www-form-urlencoded');
     ajaxRequest.send(null);
     ajaxRequest.onreadystatechange = function(){
       // console.log(ajaxRequest.readyState);
        if (ajaxRequest.readyState == 4 && ajaxRequest.status == "200"){
           var workList=JSON.parse(ajaxRequest.responseText);
           // console.log(workList);
           var length=workList.length;  console.log(workList.length);
           var workerDivName=[];
           var aloneWorker=[];
           var workListDiv=document.createElement('div'); 
           
           
           var list=document.body.appendChild(workListDiv); list.className="one";
          // console.log(list);
           
            for (var i=0; i<length; i++)
               {
                aloneWorker[i]=document.createElement('div'); 
                workerDivName[i]=list.appendChild(aloneWorker[i]); workerDivName[i].className="buttonFio";  workerDivName[i].id=i;
               // console.log(workerDivName[i]);
                workerDivName[i].innerHTML=workList[i][0]+"<pre> :смена "+workList[i][1]+"</pre>"; 
                workerDivName[i].onclick=function retunClick(){
                 this.id="fioText";
                 console.log(this.innerHTML);
                  var newText=this.innerHTML.split('<pre>');
                   // console.log(newText[0]);
                
                /*отправляем ajax запрос на сервер с данными которые мы выбрали */
                      var changeFio= new XMLHttpRequest();
                      changeFio.open('post', 'rewrite_new.php',true);
                      changeFio.overrideMimeType("application/json");
                      changeFio.setRequestHeader('Content-type','application/x-www-form-urlencoded');
                      var sendMessage='fioText='+JSON.stringify(newText[0]);
                      changeFio.send(sendMessage);
                       changeFio.onreadystatechange = function(){
                        //  if (changeFio.readyState == 4 && changeFio.status == "200") 
                        //  {
                           // console.log(changeFio.responseText);
                       //   }
                       }
                     list.remove(); 
                     
                   }
                 } 
                
             }
  
            /*--------------------------------------------------------------------------*/
        else 
         { // console.log("ошибка");
            
         }    

     };

     //------------------------------------------------------------------//

//var workListDiv=document.createElement('div'); workListDiv.className="one";

/*--------------------------------------------------*/
//console.log(selectWorker); 
/*let function checkClick(){
  var Myobject=document.getElementById('text');]
  var clickFunction = function (event) {
    //do some stuff here
    window.removeEventListener('click',clickFunction, false );

};
}*/
var oneclick=document.body.addEventListener('click',function(){

//  document.body.removeEventListener('click',oneclick, false )
var firstmenu=document.createElement('div'); firstmenu.className="one";
var subFirstMenu=document.createElement('div');  subFirstMenu.className="button"; subFirstMenu.innerHTML="Работник уходит в отпуск";
var subSecondMenu=document.createElement('div');  subSecondMenu.className="button"; subSecondMenu.innerHTML="Работник уходит на больничный";
var subTreeMenu=document.createElement('div');  subTreeMenu.className="button"; subTreeMenu.innerHTML="Работник закрыл больничный";
var subFourMenu=document.createElement('div');  subFourMenu.className="button"; subFourMenu.innerHTML="Работник переходит на другую смену";
var subFiveMenu=document.createElement('div');  subFiveMenu.className="button"; // subFiveMenu.innerHTML="Работник уволился";

var Mymenu=document.body.appendChild(firstmenu);  Mymenu.innerHTML="Имя работника";
var menu1=Mymenu.appendChild(subFirstMenu);
var menu2=Mymenu.appendChild(subSecondMenu);
var menu3=Mymenu.appendChild(subTreeMenu);
var menu4=Mymenu.appendChild(subFourMenu);
var menu5=Mymenu.appendChild(subFiveMenu);  menu5.innerHTML="Работник уволился";
//console.log(menu5);

var menu=document.getElementsByClassName('one');
var menuButton=document.getElementsByClassName('button');

 menuButton[0].onclick= function()
     {
  var formDateStartVacation=document.createElement('form'); formDateStartVacation.name="vacation";    formDateStartVacation.method="POST";  formDateStartVacation.action="rewrite.php";     /////////////////////////////////////////////////////////////////
  var inputStart=document.createElement('input');  inputStart.className="input"; inputStart.type="Date";  inputStart.name="vacationStart"; inputStart.value="2019-01-01"; 
  var inputEnd=document.createElement('input');   inputEnd.className="input"; inputEnd.type="Date";  inputEnd.name="vacationEnd"; inputEnd.value="2019-02-01";
  var divButton=document.createElement('div');  divButton.className="buttonSend"; 
  var ajaxSend = new XMLHttpRequest();
        menu[0].remove(); 
        var newDiv=document.createElement('div');    newDiv.className="button";    newDiv.innerHTML="Работник уходит в отпуск";
        var formdiv=document.createElement('div');   formdiv.className="form";     formdiv.innerHTML="Укажите даты начала и окончания отпуска: ";
        var enddiv=document.createElement('div');    enddiv.className="form";
       

       
       
        //document.appendChild(newDiv);
       document.body.appendChild(newDiv);
       document.body.appendChild(formdiv);
        
        formdiv.appendChild(formDateStartVacation);
        var vacStart=formDateStartVacation.appendChild(inputStart); 
        var vacEnd=formDateStartVacation.appendChild(inputEnd);   
        var varSend=formDateStartVacation.appendChild(divButton);  varSend.innerHTML="Записать"
        

         varSend.addEventListener('click',function(){   // нажатие кнопки на div области под название divButton запускает выполнение функции
         var ajaxSend = new XMLHttpRequest();
         var jsonString= {"vacationStart":vacStart.value, "vacationEnd":vacEnd.value};  var json_upload = 'ourData='+JSON.stringify(jsonString);
         console.log(json_upload);
          ajaxSend.open('POST','rewrite_new.php',true);  
        ajaxSend.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        /*   var sendInfo={
             vacStart.name: vacStart.value,
             vacEnd.name: vacEnd.value
            };*/   
          divButton.className="buttonSendAfterClick";        //console.log("Нажатие кнопки записать");
         ajaxSend.send(json_upload);
        /* console.log(vacStart.name);
         console.log(vacStart.value);
         console.log(vacEnd.name);
           console.log(vacEnd.value);*/

        ajaxSend.onreadystatechange=function(){
            if ((ajaxSend.readyState==4) && (ajaxSend.status==200))
            {
               alert("успех получен ответ от сервера: "+ajaxSend.responseText);
               document.body.removeChild(formdiv);
               newDiv.innerHTML="Данные записаны в базу данных.<br/><br/> <a class=\"link\" href=\"index.php\">Нажмите для возврата на главную</a>";
            }
             else 
               {
                console.log("неудача ответ сервера: "+ajaxSend.status);
               }
        }
    });


  }
  menuButton[1].onclick=function()   /*на больничный */
  {
    menu[0].remove(); 
  var newDiv=document.createElement('div');    newDiv.className="button";    newDiv.innerHTML="Работник уходит на больничный";
  var formDateStartVacation=document.createElement('form');  formDateStartVacation.name="hospital";    formDateStartVacation.method="POST";  formDateStartVacation.action="rewrite.php";     /////////////////////////////////////////////////////////////////
  var inputDate=document.createElement('input');  inputDate.className="input"; inputDate.type="Date";  inputDate.name="hospitalStartDate"; inputDate.value="2019-01-01"; 
  var divButton=document.createElement('div');  divButton.className="buttonSend";  
   document.body.appendChild(newDiv);
   var formdiv=document.createElement('div'); formdiv.className="form"; formdiv.innerHTML="Укажите дату выхода на больничный";
      document.body.appendChild(formdiv);   
       formdiv.appendChild(formDateStartVacation); 
      formDateStartVacation.appendChild(inputDate);
       formDateStartVacation.appendChild(divButton);  
       var varSend=formDateStartVacation.appendChild(divButton).innerHTML="Записать";
       varSend.addEventListener("click",function(){
        var ajaxSend=new XMLHttpRequest(); 
        var jsonString={"hospitalStartDate":inputDate.value}

       }
        );


      

 }
  menuButton[2].onclick=function()
     {
        menu[0].remove(); 
        var newDiv=document.createElement('div');
        var formdiv=document.createElement('div');
        newDiv.className="button"; formdiv.className="form";
        newDiv.innerHTML="Работник закрыл больничный";
        //document.appendChild(newDiv);
       document.body.appendChild(newDiv);
       document.body.appendChild(formdiv);
       formdiv.innerHTML="Меню выбора даты окончания больничного";


     }
    menuButton[3].onclick=function()
     {
        menu[0].remove(); 
        var newDiv=document.createElement('div');
        var formdiv=document.createElement('div');
        newDiv.className="button"; formdiv.className="form";
        newDiv.innerHTML="Работник переходит на другую смену";
        //document.appendChild(newDiv);
       document.body.appendChild(newDiv);
       document.body.appendChild(formdiv);
       formdiv.innerHTML="Меню выбора смены";

     }
    

      menuButton[4].onclick=function()
     {
        menu[0].remove(); 
        var newDiv=document.createElement('div');
        var formdiv=document.createElement('div');
        newDiv.className="button"; formdiv.className="form";
        newDiv.innerHTML="Работник уволился";
        //document.appendChild(newDiv);
       document.body.appendChild(newDiv);
       document.body.appendChild(formdiv);
       formdiv.innerHTML="Данные из базы данных удалены";
     }
});
</script> 


<?php 
}
?>
</body>
</html>
