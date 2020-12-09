$(document).ready(function () {
    $('#agregarart').click(function (e) {
        e.preventDefault();
        var datos = $('#agregar_producto').serialize();
        // console.log(datos);
        $.ajax({
            url: '../consultas/crudNVenta.php',
            type: 'POST',
            async: true,
            data: datos,
            success: function (response) {
                if (response == 'error') {
                    console.log(response)
                } else {
                    if (response == 'Cantidad Insuficiente') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oopss...',
                            text: 'La cantidad es mayor de lo que hay en stock',
                            showConfirmButton: false,
                            timer: 2500
                        })
                    }else if(response == 'Cantidad Negativa'){
                        Swal.fire({
                            icon: 'error',
                            title: 'Oopss...',
                            text: 'La cantidad es debe ser al menos 1',
                            showConfirmButton: false,
                            timer: 2500
                        })
                    }else if(response == 'success'){
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Se han agregado correctamente el producto',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        
                        location.reload();
                    }else{
                        console.log(response);
                    }
                }
            },
            error: function (error) {
                console.log(error);
            }
        })
    });

    $('.boton_eliminar_cuenta').click(function (e){
        e.preventDefault();
        var id = $(this).attr('id_cuenta');
        var Nombre = $(this).attr('nombre_producto');
        var Cuenta = $(this).attr('cantidad_producto');
        var total = $(this).attr('total');
        var id_producto = $(this).attr('id_producto');
        var action = 'eliminar';
        // console.log(id,Cuenta,id_producto);
        sendDataCuentasEliminar(id,Cuenta,id_producto,action,total);
    });

    $('#agregar_nuevo_cliente').click(function (e){
        e.preventDefault();
        Swal.fire({
            title: '<h1 class="my-2 modalh1">Agregar Cliente</h1>',
            showCancelButton: true,
            cancelButtonColor: '#dc3545',
            cancelButtonText: 'Cancelar',
            showConfirmButton: true,
            confirmButtonColor: '#28a745',
            confirmButtonText: 'Agregar',
            html: 
            '<p>Si el cliente ya existe salga de la ventana</p>'+
            '<form action="" method="post" id="agregar_new_cliente" class="form-control">'+
                '<label>Nombre del Cliente<span class="span">*</span></label>'+
                '<input type="text" required name="nombre" class="form-control">'+
                '<label>Primer Apellido del Cliente<span class="span">*</span></label>'+
                '<input type="text" required name="apellido_p" class="form-control">'+
                '<label>Segundo Apellido del Cliente<span class="span">*</span></label>'+
                '<input type="text" required name="apellido_m" class="form-control">'+
                '<label>Dirección</label>'+
                '<input type="text" name="direccion" class="form-control">'+
                '<label>Telefono</label>'+
                '<input type="text" name="telefono" class="form-control" onkeypress="return solonumeros(event)" maxlength="10" minlenght="10">'+
                '<label>Correo<span class="span">*</span></label>'+
                '<input type="email" required name="correo" class="form-control">'+
                '<label>Negocio</label>'+
                '<input type="text" name="negocio" class="form-control">'+
                '<label>Comision Registrada<span class="span">*</span></label>'+
                '<input type="text" required class="form-control" value="Nuevo Cliente" disabled>'+
                '<input type="hidden" name="comision" value="1">'+
            '</form>'
        }).then((result) => {
            if (result.isConfirmed) {
                guardarNuevoCliente();
            }
        })
    });

    $('#completar_venta').click(function (e){
        e.preventDefault();
        // var data = $('.agregar_nueva_venta').serialize();
        // console.log(data);

        $.ajax({
            url: '../consultas/crudNVenta.php',
            type: 'POST',
            async: true,
            data: $('.agregar_nueva_venta').serialize(),
            success: function (response) {
                if (response == 'datos vacios'){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oopss...',
                        text: 'hay datos vacios, recuerda llenarlos',
                        showConfirmButton: false,
                        timer: 2000
                    })
                }else if(response == 'error'){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oopss...',
                        text: 'No se pudo registrar correctamente la venta',
                        footer: 'Si el error perciste, llame al programador'
                    })
                }else{
                    console.log(response);
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Se han agregado correctamente el producto',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    
                    window.location.href = '../vistas/detalles.php?id='+response;
                }
            },
            error: function (error) {
                console.log(error);
            }
        })
    });

    // restar producto
    $('.restar_cantidad').click(function(e){
        e.preventDefault();
        var action = 'restar producto';
        var id_cuenta = $(this).attr('id_cuenta');
        $.ajax({
            url: '../consultas/crudNVenta.php',
            type: 'POST',
            async: true,
            data: {
                action: action,
                id_cuenta: id_cuenta
            },

            success: function (response) {
                if (response == 'error') {
                    console.log(response);
                }else if(response == 'success'){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Se resto correctamente',
                        showConfirmButton: false,
                        timer: 1500
                    })

                    location.reload();
                }else if(response == 'algo salio mal al guardar venta cuentas'){
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Algo Salio mal, Regarga la pagina y vuelve a intentarlo',
                        footer: 'Si el error continua Contactar al Programador'
                    })
                }else{
                    console.log(response);
                }
            },
            error: function (error){
                console.log(error);
            }
        })
    });
    
    // sumar producto
    $('.sumar_cantidad').click(function(e){
        e.preventDefault();
        var action = 'sumar producto';
        var id_cuenta = $(this).attr('id_cuenta');
        $.ajax({
            url: '../consultas/crudNVenta.php',
            type: 'POST',
            async: true,
            data: {
                action: action,
                id_cuenta: id_cuenta
            },

            success: function (response) {
                if (response == 'error') {
                    console.log(response);
                }else if(response == 'cantidad insuficiente'){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oopss...',
                        text: 'Ya no puedes agregar más el producto se acabo',
                    })
                }else if(response == 'success'){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Se sumo correctamente',
                        showConfirmButton: false,
                        timer: 1500
                    })

                    location.reload();
                }else if(response == 'salio un error'){
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Algo Salio mal, Regarga la pagina y vuelve a intentarlo',
                        footer: 'Si el error continua Contactar al Programador'
                    })
                }else{
                    console.log(response);
                }
            },
            error: function (error){
                console.log(error);
            }
        })
    });

});

$('.busqueda').select2();
$('#cliente_id').select2();
$('#autoriza').select2();
$('#comision_id').select2();
$('#fpago_id').select2();

function sendDataCuentasEliminar(id_vc,cantidad,id_p,action,total) {
    $.ajax({
        url: '../consultas/crudNVenta.php',
        type: 'POST',
        async: true,
        data: {
            id_venta_cuenta: id_vc,
            cantidad: cantidad,
            id_producto: id_p,
            action: action,
            total: total
        },

        success: function (response) {
            if (response == 'error') {
                console.log('error');
            } else {
                if (response == 'mayor cantidad') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oopss...',
                        text: 'La cantidad es mayor, no se puede remover',
                        showConfirmButton: false,
                        timer: 2000
                    })
                }else if(response == 'cantidad menor'){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oopss...',
                        text: 'La cantidad es menor o negativa, no se puede remover',
                        showConfirmButton: false,
                        timer: 2000
                    })
                }else if(response == 'success'){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Se elimino el producto',
                        showConfirmButton: false,
                        timer: 1500
                    })

                    location.reload();
                }else{
                    console.log(response);
                }
            }
        },
        error: function (error) {
            console.log(error);
        }
    })
}

function guardarNuevoCliente() {
    var data = $('#agregar_new_cliente').serialize();
    var datos = data + '&action=agregar%20un%20nuevo%20cliente';
    // console.log(datos);
    $.ajax({
        url: '../consultas/crudNVenta.php',
        type: 'POST',
        async: true,
        data: datos,

        success: function (response) {
            if (response == 'error') {
                console.log(response);
            } else if (response == 'success'){
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Se registro el cliente correctamente',
                    showConfirmButton: false,
                    timer: 1500
                })

                location.reload();
            } else if (response == 'vacio' ){
                Swal.fire({
                    icon: 'error',
                    title: 'Oopss...',
                    text: 'Te falto llenar campos Obligatorios'
                })
            } else if (response == 'el correo ya existe'){
                Swal.fire({
                    icon: 'error',
                    title: 'Correo Repetido',
                    text: 'El correo que intentas registar ya existe, verifica si el usuario esta guardado con otro nombre o pide otro correo',
                    footer: 'Si el correo nunca se a registrado, favor de llamar al Programador'
                })
            } else {
                console.log(response);
            }
        },
        error: function (error) {
            console.log(error);
        }
    });
}