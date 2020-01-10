<?php
ini_set("display_errors", 1);   
error_reporting(E_ERROR|E_PARSE);

 echo '     <form method="POST">
                       <b>Форма регистрации</b> 
                        <br><br> Введите логин<br>
                       <input type="text" name="NewLogin"><br>
                        Введите пароль<br>
                       <input type="password" name="NewPassword1"><br>
                        Введите пароль повторно<br>
                       <input type="password" name="NewPassword2"><br>                     
                    <input type="submit" value="Регистрация">
                    <a href="index.php">
                    <input type="button" value="Уже есть аккаунт"></a>
                    </form>';
if($_POST['NewLogin']!=null&$_POST['NewPassword1']!=null&$_POST['NewPassword2']!=null) 
 { 
  if (preg_match("/[0-9a-z_]/i", $_POST['NewLogin'])) 
   {
       if($_POST['NewPassword1']==$_POST['NewPassword2'])
        {
        $fReg = fopen('accounts.txt','a');
        fwrite($fReg,$_POST['NewLogin'].' '.$_POST['NewPassword1']."\n\r");
         fclose($fAdd);
         header("Location: index.php");
        }
        else
        {
            echo '<b style="color:red">Пароли не совпадают!</b>';
        }
    } 
   else { echo '<b style="color:red">Логин введен неверно!</b>';  } }

 else { echo '<b style="color:red">Нужно заполнить все поля!</b>'; } 

exit;