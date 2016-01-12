<?php
mb_internal_encoding("UTF-8");
// Initialisieren Sie eine Variable mit einer Fehlermeldung
  $error_msg = "";

  // Prüfen Sie, ob der Benutzer eingegeben
  if (!isset($_SESSION['user_id'])) {
    if (isset($_POST['submit'])) { 
      // Verbindung zu Datenbank
      include ('sql_connect.php');

      // Wir nehmen die vom Benutzer eingegebenen Daten
      $user_user_name = mysqli_real_escape_string($dbc, trim($_POST['user_name']));
      $user_user_password = mysqli_real_escape_string($dbc, trim($_POST['user-password']));
	  $user_user_password = SHA1($user_user_password);
	  $user_num = SHA1($user_user_password);
      if (!empty($user_user_name) && !empty($user_user_password)) {
        // Wir suchen nach einem Benutzernamen und Passwort in der Datenbank suchen
        $query = "SELECT `id` FROM `t2b_users` WHERE `e-mail` = '$user_user_name' AND `pass` = '$user_user_password'";
        $data = mysqli_query($dbc, $query);

        if (mysqli_num_rows($data)==1) {
          // Wenn der Benutzer vorhanden ist, umzuleiten Arbeits Seite
          $row = mysqli_fetch_array($data);
		  $_SESSION['user_id'] = $row['id'];
          $_SESSION['user_name'] = $user_user_name;
          setcookie('user_id', $row['id'], time() + (60 * 60 * 24 * 30));    // halten Sie für 30 Tage
          setcookie('user_name', $user_user_name, time() + (60 * 60 * 24 * 30));  // halten Sie für 30 Tage
          //session_register('user_id');
          //session_register('user_login');
          
          header('Location: http://www.t2b-pro.ru/schrank/index.php?id='.$user_num);
          
        }
        else {
          // die Daten falsch eingegeben
          $error_msg = 'Данные введены неверно!';
        }
      }
      else {
        // Daten nicht verfügbar
        $error_msg = 'Введите e-mail и пароль.';
      }
    }
  }
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<meta name="viewport"    content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author"      content="Alexey Burov">
	
	<title>T2B - Площадка для поиска продавцов и покупателей</title>
	

	<link rel="shortcut icon" href="assets/images/gt_favicon.png">
	
	<!-- Bootstrap itself -->
	<link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet" type="text/css">

	<!-- Custom styles -->
	<link rel="stylesheet" href="assets/css/magister.css">
	<link rel="stylesheet" href="css/bootstrap.css">
	<script src="js/bootstrap.js" type="text/javascript"></script>

	<!-- Fonts -->
	<link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link href='http://fonts.googleapis.com/css?family=Wire+One' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
</head>

<!-- use "theme-invert" class on bright backgrounds, also try "text-shadows" class -->
<body class="theme-invert">
<!--
<nav class="mainmenu">
	<div class="container">
		<div class="dropdown">
			<button type="button" class="navbar-toggle" data-toggle="dropdown"><span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
			<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
				<li><a href="#head" class="active">Hello</a></li>
				<li><a href="#about">About me</a></li>
				<li><a href="#themes">Themes</a></li>
				<li><a href="#contact">Get in touch</a></li>
			</ul>
		</div>
	</div>
</nav>
-->

<!-- Main (Home) section -->
<section class="section" id="head">
	<div class="container">

		<div class="row">
			<div class="col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1 text-center">	

				<!-- Site Title, your name, HELLO msg, etc. -->
				<h1 class="title"><font color="white">T2B</font></h1>
				
				<!-- Short introductory (optional) -->
				<h3 class="tagline"><font color="white">
					Найти благонадёжного поставщика теперь стало проще.<br>
					Убедитесь сами.</font>
				</h3>
				
				<!-- Nice place to describe your site in a sentence or two -->
				<p><button type="button" class="btn btn-default btn-lg" data-toggle="modal" data-target="#modal-1">Войти</button></p>
	
			</div> <!-- /col -->
		</div> <!-- /row -->
	
	</div>
</section>
<!--Die modalen Fenster Einreise und Anmeldung-->
<div id="modal-1" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content modal-sm">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					&times;
				</button>
				<h4>Войти</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-3"></div>
					<div class="col-lg-6">
						<?php
  						// wenn die Sitzung leer ist, zeigt eine Fehlermeldung
  						if (empty($_SESSION['user_id'])) {
    						echo '<p class="error">' . $error_msg . '</p>';
						  }
						?>
				<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
					<div class="form-group">
						<input type="e-mail" class="form-control" placeholder="E-mail" name="user_name"><br/>
						<input type="password" class="form-control" placeholder="Пароль" name="user-password">
					</div>
					<button type="submit" class="btn btn-default" name="submit" id="submit">
						<i class="fa fa-sign-in"></i> ВОЙТИ
					</button>
				</form>
			</div>
				</div>
			<div class="modal-footer">
				Забыли пароль? | 
				<a href="register.php">
				Зарегистрироваться
				</a>
			</div>
		</div>
	</div>
</div>


<!-- Second (About) section -->
<section class="section" id="about">
	<div class="container">
	
		<h2 class="text-center title">About me</h2>
		<div class="row">
			<div class="col-sm-4 col-sm-offset-2">    
				<h5><strong>Where's my lorem ipsum?<br></strong></h5>
				<p>Well, here it is: Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorum, ullam, ducimus, eaque, ex autem est dolore illo similique quasi unde sint rerum magnam quod amet iste dolorem ad laudantium molestias enim quibusdam inventore totam fugit eum iusto ratione alias deleniti suscipit modi quis nostrum veniam fugiat debitis officiis impedit ipsum natus ipsa. Doloremque, id, at, corporis, libero laborum architecto mollitia molestiae maxime aut deserunt sed perspiciatis quibusdam praesentium consectetur in sint impedit voluptates! Deleniti, sequi voluptate recusandae facere nostrum?</p>    
			</div>
			<div class="col-sm-4">
				<h5><strong>More, more lipsum!<br></strong></h5>    
				<p>Tempore, eos, voluptatem minus commodi error aut eaque neque consequuntur optio nesciunt quod quibusdam. Ipsum, voluptatibus, totam, modi perspiciatis repudiandae odio ad possimus molestias culpa optio eaque itaque dicta quod cupiditate reiciendis illo illum aspernatur ducimus praesentium quae porro alias repellat quasi cum fugiat accusamus molestiae exercitationem amet fugit sint eligendi omnis adipisci corrupti. Aspernatur.</p>    
				<h5><strong>Author links<br></strong></h5>    
				<p><a href="http://be.net/pozhilov9409">Behance</a> / <a href="https://twitter.com/serggg">Twitter</a> / <a href="http://linkedin.com/pozhilov">LinkedIn</a> / <a href="https://www.facebook.com/pozhilov">Facebook</a></p>
			</div>
		</div>
	</div>
</section>

<!-- Third (Works) section -->
<section class="section" id="themes">
	<div class="container">
	
		<h2 class="text-center title">More Themes</h2>
		<p class="lead text-center">
			Huge thank you to all people who publish<br>
			their photos at <a href="http://unsplash.com">Unsplash</a>, thank you guys!
		</p>
		<div class="row">
			<div class="col-sm-4 col-sm-offset-2">
				<div class="thumbnail">
					<img src="assets/screenshots/sshot1.jpg" alt="">
					<div class="caption">
						<h3>Thumbnail label</h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Neque doloribus enim vitae nam cupiditate eius at explicabo eaque facere iste.</p>
						<p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="thumbnail">
					<img src="assets/screenshots/sshot4.jpg" alt="">
					<div class="caption">
						<h3>Thumbnail label</h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Neque doloribus enim vitae nam cupiditate eius at explicabo eaque facere iste.</p>
						<p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
					</div>
				</div>
			</div>
			<div class="col-sm-4 col-sm-offset-2">
				<div class="thumbnail">
					<img src="assets/screenshots/sshot5.jpg" alt="">
					<div class="caption">
						<h3>Thumbnail label</h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Neque doloribus enim vitae nam cupiditate eius at explicabo eaque facere iste.</p>
						<p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="thumbnail">
					<img src="assets/screenshots/sshot3.jpg" alt="">
					<div class="caption">
						<h3>Thumbnail label</h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Neque doloribus enim vitae nam cupiditate eius at explicabo eaque facere iste.</p>
						<p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
					</div>
				</div>
			</div>

		</div>

	</div>
</section>

<!-- Fourth (Contact) section -->
<section class="section" id="contact">
	<div class="container">
	
		<h2 class="text-center title">Get in touch</h2>

		<div class="row">
			<div class="col-sm-8 col-sm-offset-2 text-center">
				<p class="lead">Have a question about this template, or want to suggest a new feature?</p>
				<p>Feel free to email me, or drop me a line in Twitter!</p>
				<p><b>gt@gettemplate.com</b><br><br></p>
				<ul class="list-inline list-social">
					<li><a href="https://twitter.com/serggg" class="btn btn-link"><i class="fa fa-twitter fa-fw"></i> Twitter</a></li>
					<li><a href="https://github.com/pozhilov" class="btn btn-link"><i class="fa fa-github fa-fw"></i> Github</a></li>
					<li><a href="http://linkedin/in/pozhilov" class="btn btn-link"><i class="fa fa-linkedin fa-fw"></i> LinkedIn</a></li>
				</ul>
			</div>
		</div>

	</div>
</section>


<!-- Load js libs only when the page is loaded. -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
<script src="assets/js/modernizr.custom.72241.js"></script>
<!-- Custom template scripts -->
<script src="assets/js/magister.js"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>
hello