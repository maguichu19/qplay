<?php

require_once 'soporte.php';

if ($_GET){
    $link = "reiniciarPassword.php?id=".$_GET["id"];
    $id = $_GET["id"];
}

if ($_POST){

  $errores = [];
  $passreg = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/";

  if (!$repositorio->getUserRepository()->existeElMail($_POST["mail"])){
    $errores[] = 'El mail no existe';
  } else{

    $miUsuario = $repositorio->getUserRepository()->getUsuarioByMail($_POST["mail"]);


    if ($miUsuario->getIdPass() != $id){
      $errores[] = "El mail ingresado no es válido para el link";
    }

    if (trim($_POST["password"]) == "") {
        $errores[] = "<b>ERROR!</b> El campo Contrase&ntilde;a no puede estar vacio.";
    } else if (strlen($_POST["password"]) < 8) {
        $errores[] = "<b>ERROR!</b> La Contraseña tiene que tener minimo 8 caracteres.";
    } else if (!preg_match($passreg, $_POST["password"])) {
        $errores[] = "<b>ERROR!</b> La Contraseña tiene que tener al menos una letra minúscula, una mayúscula y un numero.";
    }

    if (trim($_POST["password2"]) == "")
    {
        $errores[] = "<b>ERROR!</b> Tiene que confirmar su contraseña.";
    }
    if ($_POST["password"] != $_POST["password2"])
    {
        $errores[] = "<b>ERROR!</b> La contraseña y su confimacion no pueden ser distintas.";
    }

    if (!$errores){
      $miUsuario->setPassword($_POST['password']);
      $miUsuario->setIdPass();
      $repositorio->getUserRepository()->guardarUsuario($miUsuario);
      // Reenviarlo a la felicidad
      header("location:index.php");exit;
    }

  }
}
 ?>

<html>
  <head>
    <meta name="name" content="content">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Abel|Cabin|Comfortaa|Exo|Farsan|Kaushan+Script|Poiret+One|Righteous|Russo+One" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Antic|Maven+Pro|Poppins|Ubuntu" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="css/homex.css" type="text/css" />
    <link rel="stylesheet" href="css/login.css" type="text/css" />
    <link rel="stylesheet" href="css/font-awesome.css" type="text/css" />
    <title>Reiniciar contraseña</title>
  </head>
  <body>

<!-- COMIENZO DEL NAVBAR Y SU CONTENIDO -->
<!-- Para hacerlo fluido quitar "navbar-fixed-top" y sacar padding del body en la hoja del estilo -->

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand font-kaushan logo" href="index.php">QPlay</a>
      <p class="navbar-text font-farsan">Tu musica!</p>
    </div>

    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li><a class="btn btn-nav" href="login.php">Conectate <i class="fa fa-link"></i></a></li>
        <li><a class="btn btn-nav" href="register.php">Registrate <i class="fa fa-book"></i></a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- FIN DEL NAVBAR -->
<!-- COMIENZO DE JUMBOTRON -->

<div class="jumbotronlog">
  <div class="container-fluid login">
    <div class="row">
      <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
        <h3 class="text-center font-comfortaa logtit">Recuperar Contraseña</h3>

        <?php if (!empty($errores)) { ?>
          <div class="errorph">
            <?php foreach ($errores as $error) { ?>
              <p class="errcript"><?php echo $error ?></p>
            <?php } ?>
          </div>
        <?php } ?>


        <form class="form" method="post" action="<?php echo $link; ?>">

            <div class="form-group">
              <input type="email" class="form-control" id="inputEmail4" name="mail" placeholder="Email">
              <input type="password" class="form-control" id="inputEmail4" name="password" placeholder="Ingrese su nueva contraseña">
              <input type="password" class="form-control" id="inputEmail4" name="password2" placeholder="Repita la nueva contraseña">
            </div>

              <button type="submit" class="btn btn-login center-block">Enviar</button>
          </form>
        </div>
    </div>
  </div>
</div>


<!-- COMIENZO DEL FOOTER -->
<div class="container-fluid footer">
  <div class="row">
    <div class="col-md-12">
      <ul class="list-inline text-center">
        <li><a href="login.php" class="footlink">Conectate</a></li>
        <li><p></p></li>
        <li><a href="register.php" class="footlink">Registrate</a></li>
        <li><p></p></li>
        <li><a href="faq.php" class="footlink">Preguntas (FAQs)</a></li>
      </ul>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <p class="font-maven footp text-center">Diseñado y desarollado por Eugenio Vorontsov - Maggie Tobar - Sebastian Crosta</p>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <p class="text-center footlog">
        <i class="fa fa-html5"></i>
        <i class="fa fa-css3"></i>
        <i class="fa fa-github"></i>
        <i class="fa fa-git-square"></i>
        <i class="fa fa-font-awesome"></i>
        <i class="fa fa-stack-overflow"></i>
        <i class="fa fa-apple"></i>
        <i class="fa fa-android"></i>
      </p>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="line center-block"></div>
    </div>
  </div>
    <div class="row">
    <div class="col-md-12">
      <p class="font-maven text-center footp">Copyright <i class="fa fa-copyright"></i> 2016 QPlay <i class="fa fa-registered"></i> All Rights Reserved.</p>
    </div>
  </div>
</div>

<!-- FIN DEL FOOTER -->
<!-- COMIENZO DE JAVASCRIPT PLUGINS -->

<script type="text/javascript" src="js/jquery-2.2.3.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/botcolaps.js"></script>

</body>
</html>
