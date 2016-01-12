<?php
if(isset($_POST['submit'])){
  include 'sql_connect.php';
  //$error_message = "";
  $user_name = $_POST['user_name'];
  $user_pass = $_POST['user-password'];
  $user_pass_control = $_POST['user-password-control'];
  //Проверяем заполняемость полей и равенство паролей, если всё ОК, то идём дальше
  if(!empty($user_name)){
    if(!empty($user_pass)){
      if(!empty($user_pass_control)){
        if($user_pass == $user_pass_control){
          //Шифруем пароль
          $user_pass1 = SHA1($user_pass);
          $user_num = SHA1($user_pass1);         
          //Формируем запрос к базе данных
          $query = "INSERT INTO `t2b_users` (`e-mail`, `pass`, `num`) VALUES ('$user_name', '$user_pass1', '$user_num')";
          //Вносим данные в базу данных
          $data = mysqli_query($dbc, $query) or die ('Ошибка при добавлении нового пользователя');
          //Создаём почтовое сообщение и высылаем пользователю на почту!
          $to = $user_name;
          $subject = "Регистрация на t2b-pro";
          $message = 'Для окончания регистрации перейдите по ссылке: http://www.t2b-pro.ru/schrank/index.php?id='.$user_num;
          $headers .= "From: администрация t2b-pro"; 
          mail($to, $subject ,$message, $headers);
        }else{
          $error_message = "Введённые пароли различаются! Введите снова!";
        }
      }else{
        $error_message = "Повторите пароль!";
      }
    }else{
      $error_message = "Введите пароль!";
    }
  }else{
    $error_message = "Заполните поле e-mail";
  }
  include 'sql_connect_close.php';
}

?>

<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Регистрация на площадке t2p-pro</title>

    <!-- Bootstrap itself -->
	  <link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet" type="text/css">

    <!-- Bootstrap -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
	  <link href="assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/atmo.css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	  <link href='http://fonts.googleapis.com/css?family=Wire+One' rel='stylesheet' type='text/css'>
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  </head>
  <body>
    
    <div class="conteiner">
      <div class="row">
        <div class="col-lg-4 col-lg-offset-4 visible-lg">
          <div class="center-block">
            <p align="center"><img src="assets/images/handshake.png"></p>
            
          </div>    
        </div>      
      </div>
      <div class="row">
        <div class="col-md-4 col-md-offset-4 visible-md">
          <div class="center-block">
            <p align="center"><img src="assets/images/handshake.png" width="200"></p>
          </div>    
        </div>      
      </div>
      <div class="row">
        <div class="col-sm-6 col-sm-offset-3 visible-sm">
          <div class="center-block">
            <p align="center"><img src="assets/images/handshake.png" width="150"></p>
          </div>    
        </div>      
      </div>
      <div class="row">
        <div class="col-xs-6 col-xs-offset-3 visible-xs">
          <div class="center-block">
            <p align="center"><img src="assets/images/handshake.png" width="100"></p>
          </div>    
        </div>      
      </div>
		<div class="row">
      <div class="center-block">
			<div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-7 col-xs-offset-3">
        <p align="center"><h3 align="center"><font color="#666">Регистрация</font></h3></p>
        <?php
        if(!empty($error_message)){
          echo '<table align="center"><tr class="danger"><td><font color="#d9534f">'.$error_message.'</font></td></tr></table><br/>';
        }
        if(empty($error_message)){
          echo '<table align="center"><tr class="danger"><td><font color="#5cb85c">Чтобы закончить регистрацию пройдите в Ваш почтовый ящик и перейдите по ссылке, указанной в письме!</font></td></tr></table><br/>';
        }           
        ?>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
					<div class="form-group">
						<input type="email" class="form-control" placeholder="Ваш E-mail" name="user_name"><br/>
						<input type="password" class="form-control" placeholder="Пароль" name="user-password"><br/>
            <input type="password" class="form-control" placeholder="Повторите пароль" name="user-password-control">
					</div>
          <p align="center">
					<button type="submit" class="btn btn-info" name="submit">
						 <font color="white">РЕГИСТРАЦИЯ</font>
					</button>
          </p>
				</form>
       </div>
       </div>
		</div>
	</div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="assets/js/bootstrap.js"></script>
    
  </body>
</html>