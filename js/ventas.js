$(document).ready(function () {
    $('.registrar_factura').click(function (e){
        e.preventDefault();
        var id_cliente = $(this).attr('id_cliente');
        $.ajax({
            url: '../consultas/crudNVenta.php',
            type: 'POST',
            async: true,
            data: {
                id_cliente: id_cliente,
                action: 'Recuperar datos de cliente'
            },

            success: function(response){
                if(response == 'error'){
                    console.log(response);
                }else{
                    var info = JSON.parse(response);
                    // console.log(info);
                    Swal.fire({
                        title: '<h1 class="my-2 modalh1">Agregar Factura al cliente "'+ info.nombre +'"</h1>',
                        showCancelButton: true,
                        cancelButtonColor: '#dc3545',
                        cancelButtonText: 'Cancelar',
                        showConfirmButton: true,
                        confirmButtonColor: '#28a745',
                        confirmButtonText: 'Agregar Factura',
                        html: '<form action="" id="registrar_factura" method="post">' +
                            '<input type="hidden" name="action" value="registrar nueva factura">'+
                            '<label>Razon Social</label>' +
                            '<input type="text" placeholder="Razon Social" name="razon_social" required class="form-control">' +
                            '<label>RFC</label>' +
                            '<input type="text" placeholder="RFC" name="rfc" required class="form-control uppercase" maxlength="13" minlenght="13">' +
                            '<label>Domicilio Fiscal</label>' +
                            '<input type="text" placeholder="Domicilio Fical" name="domicilio_fiscal" required class="form-control" value="'+info.direccion+'">' +
                            '<label>Correo</label>' +
                            '<input type="text" placeholder="ejemplo@ejemplo.com" name="correo" value="'+ info.correo +'" required class="form-control">' +
                            '<label>Telefono</label>' +
                            '<input type="text" placeholder="numero telefonico" name="telefono" value="'+info.telefono+'" maxlength="10" minlenght="10" onkeypress="return solonumeros(event)" required class="form-control">' +
                            '</form>'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            registrarFactura(info.id);
                        }
                    })
                }
            }
        })
    });

    $('.revisar_factura').click(function (e){
        e.preventDefault();
        var id_cliente = $(this).attr('id_cliente');
        var action = 'visualizar factura';
        $.ajax({
            url: '../consultas/crudClientes.php',
            type: 'POST',
            async: true,
            data: {
                action: action,
                id_cliente: id_cliente
            },

            success: function (response) {
                if (response == 'error') {
                    console.log(response);
                }else{
                    var info = JSON.parse(response);
                    // console.log(info);
                    Swal.fire({
                        title: '<h1 class="my-2 modalh1">Ver Factura del cliente "'+ info.nombre +'"</h1>',
                        showCancelButton: false,
                        showConfirmButton: false,
                        html: 
                            '<label>Razon Social</label>' +
                            '<input type="text" disabled value="'+ info.razon_social +'" class="form-control">' +

                            '<label>RFC</label>' +
                            '<input type="text" disabled class="form-control uppercase" value="'+ info.rfc +'">' +

                            '<label>Domicilio Fiscal</label>' +
                            '<input type="text" disabled value="'+ info.domicilio_fiscal +'" class="form-control">' +

                            '<label>Correo</label>' +
                            '<input type="text" disabled value="'+ info.correo +'" class="form-control">' +

                            '<label>Telefono</label>' +
                            '<input type="text" disabled value="'+info.telefono +'" class="form-control">'
                    })
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    // editar cliente
    $('.editar_cliente').click(function (e){
        e.preventDefault();
        var id_cliente = $(this).attr('id_cliente');
        $.ajax({
            url: '../consultas/crudNVenta.php',
            type: 'POST',
            async: true,
            data: {
                id_cliente: id_cliente,
                action: 'Recuperar datos de cliente'
            },

            success: function(response){
                if(response == 'error'){
                    console.log(response);
                }else{
                    var info = JSON.parse(response);
                    // console.log(info);
                    Swal.fire({
                        title: '<h1 class="my-2 modalh1">Editar al cliente "'+ info.nombre +'"</h1>',
                        showCancelButton: true,
                        cancelButtonColor: '#dc3545',
                        cancelButtonText: 'Cancelar',
                        showConfirmButton: true,
                        confirmButtonColor: '#ffc107',
                        confirmButtonText: 'Editar',
                        html: '<form action="" id="editar_cliente" method="post">' +
                            '<input type="hidden" name="action" value="editar cliente">'+
                            '<input type="hidden" name="id_cliente" value="'+info.id+'"'+

                            '<label>Nombre</label><span class="span">*</span>' +
                            '<input type="text" placeholder="Nombre" name="nombre" value="'+info.nombre+'" required class="form-control">' +

                            '<label>Apellido Paterno</label><span class="span">*</span>' +
                            '<input type="text" placeholder="Apellido paterno" name="apellido_p" value="'+info.apellido_p+'" required class="form-control">' +

                            '<label>Nombre</label><span class="span">*</span>' +
                            '<input type="text" placeholder="Apellido materno" name="apellido_m" value="'+info.apellido_m+'" required class="form-control">' +

                            '<label>Dirección</label>' +
                            '<input type="text" placeholder="Dirección" name="direccion" value="'+info.direccion+'" class="form-control">' +

                            '<label>Telefono</label>' +
                            '<input type="text" placeholder="numero telefonico" name="telefono" value="'+info.telefono+'" maxlength="10" minlenght="10" onkeypress="return solonumeros(event)" required class="form-control">' +

                            '<label>Correo</label><span class="span">*</span>' +
                            '<input type="text" placeholder="ejemplo@ejemplo.com" name="correo" value="'+ info.correo +'" required class="form-control">' +

                            '<label>Negocio</label>' +
                            '<input type="text" placeholder="Negocio" name="negocio" required class="form-control" value="'+info.negocio+'">' +
                            '</form>'
                    }).then((result) => {
                        if(result.isConfirmed){
                            var datos = $('#editar_cliente').serialize();
                            // console.log(datos);
                            $.ajax({
                                url: '../consultas/crudClientes.php',
                                type: 'POST',
                                async: true,
                                data: datos,

                                success: function(respuesta){
                                    if(respuesta == 'error'){
                                        console.log(respuesta);
                                    }else if(respuesta == 'vacio'){
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oopss...',
                                            text: 'El Nombre y el Correo son necesarios'
                                        })
                                    }else if(respuesta == 'no se edito'){
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: 'Recarga la página y vuelve a intentarlo',
                                            footer: 'Si el error continua llamar al programador'
                                        })
                                    }else if(respuesta == 'success'){
                                        Swal.fire({
                                            position: 'top-end',
                                            icon: 'success',
                                            title: 'Se edito correctamente',
                                            showConfirmButton: false,
                                            timer: 1500
                                        })

                                        location.reload();
                                    }else{
                                        console.log(respuesta);
                                    }
                                }
                            })
                        }
                    })
                }
            },

            error: function(error){
                console.log(error);
            }
        });
    });
});

function registrarFactura(id_cliente){
    var data = $('#registrar_factura').serialize();
    var datos = data + '&id_cliente='+id_cliente;
    $.ajax({
        url: '../consultas/crudClientes.php',
        type: 'POST',
        async: true,
        data: datos,

        success: function (response) {
            if (response == 'error') {
                console.log(response);
            }else{
                if(response == 'success'){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Se registro Correctamete la factura',
                        showConfirmButton: false,
                        timer: 1500
                    })

                    location.reload();
                }else if(response == 'no se pudo registrar'){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oopsss...',
                        text: 'No se pudo registrar la factura',
                        footer: 'Si el error persiste, llama al Programador'
                    })
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Oopsss...',
                        text: 'No se pudo registrar la factura',
                        footer: 'Si el error persiste, llama al Programador'
                    })
                }
                console.log(response);
            }
        },
        error: function (error) {
            console.log(error);
        }
    });
}