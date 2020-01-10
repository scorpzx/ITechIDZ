<html>
   <head>
   <meta charset="utf-8">
      <title>
          Калькулятор расходов пользователя
     </title>
   </head>
   <body>

<?php 
header('Content-type: text/html; charset=utf-8');
session_start();
$fs = fopen('accounts.txt','r');
ini_set("display_errors", 1);   
error_reporting(E_ERROR|E_PARSE);
if(!$fs)
    {
        echo("Невозможно открыть файл");
    }
else
    {
        $array;
        while(!feof($fs))
        {
            $logAndPass = fgets($fs);    
            $login = trim(strtok($logAndPass,' '));
            $password = trim(strtok(" \n\r"));
            $array[$login]=$password;
        }
        fclose($fs);
//       var_dump($array);
     }  

//echo("<br>");
//var_dump($_SESSION);

if($_SESSION['login']==null){
    echo '     <form method="POST">
                       <b>Форма авторизации</b> 
                        <br><br> Введите логин<br>
                       <input type="text" name="login"><br>
                        Введите пароль<br>
                       <input type="password" name="password"><br>                     
                    <input type="submit" value="Вход">
                    <a href="registration.php">
                    <input type="button" value="Регистрация"></a>
                    </form>';
if($_POST['login']!=null) 
 { 
  if (preg_match("/[0-9a-z_]/i", $_POST['login'])) 
   {
       if(array_key_exists($_POST['login'],$array) && $_POST['password']==$array[$_POST['login']])
        {
             $_SESSION['login']=$_POST['login'];
             echo '<b style="color:green">Вы успешно авторизовались</b>';
            header("Location: index.php");
        }
        else
        {
            echo '<b style="color:red">Неправильный логин или пароль!!!</b>';
        }
    } 
   else { echo '<b style="color:red">Логин введен неверно!</b>';  } }

 else { echo '<b style="color:red">Логин не введен!</b>'; } 
}
else{
    echo'Hello, ',$_SESSION['login'],"   ";
    echo '<a href="logout.php"><input type="button" value="Выход"></a>';
    echo '<form method="POST">
                       <b>Добавление информации о расходах</b> 
                        <br> Введите название &nbsp
                       <input type="text" name="AddName"><br>
                        Введите стоимость
                       <input type="number" name="AddCost"><br>                     
                    <input type="submit" value="Добавить">
                    </form>';

  if($_POST['AddName']!=null&$_POST['AddCost']!=null) 
    { 
        $fAdd = fopen('info\\'.$_SESSION['login'].'.txt','a');
        fwrite($fAdd,$_POST['AddName'].' '.$_POST['AddCost']."\n\r");
        fclose($fAdd);
         header("Location: index.php");
    }
    else{
        echo 'Нужно ввести данные!';
    }






    $fcost = fopen('info\\'.$_SESSION['login'].'.txt','r');

if(!$fcost)
    {
        echo'<br><br>Информация о расходах отсутствует!';
    }
else
    {
         
        $CostArr;
        while(!feof($fcost))
        {
            $str = fgets($fcost);    
            $CostArr[]=$str;
        }
        fclose($fcost);
 
 //   var_dump($CostArr);
 
    echo '<table border="1">',
        '<tr><th>Название позиции</th><th>Стоимость</th>';
        $count = count($CostArr);
        $sumCost=0;
        for($i =0; $i < $count-1; $i++){
             $str = $CostArr[$i];
             $Name = strtok($str,' ');
             $Cost = strtok(" \n\r");
             $sumCost+=$Cost;
             echo '<tr><td>',$Name,'</td>',
                '<td>',$Cost,'</td>','</tr>';
        }
        echo '<tr><td>Всего</td>',
                '<td>',$sumCost,'</td>','</tr>';

     echo '</table>';
    }
  

}
?>
</body>
</html>