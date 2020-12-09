<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">

    <!-- Styles -->
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/footer.css">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="../registros/login.php">
                    <img src="../img/logo.png" alt="Sanoil" height="50" >
                </a>
                <div align="center">
                    <p id="diaSemana" style="display: inline;"></p>
                    <p id="dia" style="display: inline;"></p>
                    <p style="display: inline;"> de </p>
                    <p id="mes" style="display: inline;"></p>
                    <p style="display: inline;"> del </p>
                    <p id="year" style="display: inline;"></p>
                    <p style="display: inline; color:white;">_</p>
                    <p id="horas" style="display: inline;"></p>
                    <p style="display: inline;">:</p>
                    <p id="minutos" style="display: inline;"></p>
                    <p style="display: inline;">:</p>
                    <p id="segundos" style="display: inline;"></p>
                    <p id="ampm" style="display: inline;"></p>
                </div>
            </div>
        </nav>
    </div>
    <script src="../js/fecha.js"></script>
</body>
<footer>
    <?php include("../plantillas/footer.php"); ?>
</footer>

</html>