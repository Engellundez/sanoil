<meta charset="utf-8">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

<!-- Fonts -->
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

<!-- bootstrap -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">

<!-- ajax -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

<!-- jquery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

<!-- icon -->
<link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">

<!-- Styles -->
<link rel="stylesheet" href="../css/global.css">
<link rel="stylesheet" href="../css/sidebar.css">
<link rel="stylesheet" href="../css/footer.css">
<link rel="stylesheet" href="../css/modal.css">
<link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">

<!-- Busqueda en Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

<!-- plotly js -->
<script src="../libreria/plotlyjs/plotly-latest.min.js"></script>

<!-- acepta solo numeros -->
<script>
    function solonumeros(e) {
        key = e.keyCode || e.which;
        teclado = String.fromCharCode(key);
        numeros = "0123456789";
        especiales = "8-37-38-46"; //array            
        teclado_especial = false;
        for (var i in especiales) {
            if (key == especiales[i]) {
                teclado_especial = true;
            }
        }
        if (numeros.indexOf(teclado) == -1 && !teclado_especial) {
            return false;
        }
    };
    function solonumeros_Punto(e) {
        key = e.keyCode || e.which;
        teclado = String.fromCharCode(key);
        numeros = "0123456789.";
        especiales = "8-37-38"; //array            
        teclado_especial = false;
        for (var i in especiales) {
            if (key == especiales[i]) {
                teclado_especial = true;
            }
        }
        if (numeros.indexOf(teclado) == -1 && !teclado_especial) {
            return false;
        }
    };
</script>
<!-- fin solo numeros -->