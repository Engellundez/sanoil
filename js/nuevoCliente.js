$(document).ready(function () {
    $('#registrar_cliente').click(function (e) {
        e.preventDefault();

        $.ajax({
            url: '../consultas/crudClientes.php',
            type: 'POST',
            async: true,
            data: $('#registrar_nuevo_cliente').serialize(),

            success: function (response) {
                if (response == 'error') {
                    console.log(response);
                } else if (response == 'correo registrado') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oopss...',
                        text: 'El correo ya esta registrado, Revisa que el usuario no este registrado'
                    });
                } else if (response == 'success') {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Se registro Correctamete el cliente',
                        showConfirmButton: false,
                        timer: 1500
                    })

                    window.location.href = "clientes.php";
                } else {
                    // console.log(response);
                    $.ajax({
                        url: '../consultas/crudNVenta.php',
                        type: 'POST',
                        async: true,
                        data: {
                            action: 'Recuperar datos de cliente',
                            id_cliente: response
                        },

                        success: function(respuesta){
                            if(respuesta == 'error'){
                                console.log(respuesta);
                            }else{
                                var info = JSON.parse(respuesta);
                                // console.log(info);
                                Swal.fire({
                                    title: '<h1 class="my-2 modalh1">Agregar Factura</h1>',
                                    showCancelButton: true,
                                    cancelButtonColor: '#dc3545',
                                    cancelButtonText: 'Cancelar',
                                    showConfirmButton: true,
                                    confirmButtonColor: '#28a745',
                                    confirmButtonText: 'Agregar Factura',
                                    html: '<form action="" id="registrar_factura" method="post">' +
                                        '<input type="hidden" name="action" value="registrar nueva factura">'+
                                        '<input type="hidden" name="id_cliente" value="'+info.id+'"'+

                                        '<label>Razon Social</label>' +
                                        '<input type="text" placeholder="Razon Social" name="razon_social" required class="form-control">' +
                                        
                                        '<label>RFC</label>' +
                                        '<input type="text" placeholder="RFC" name="rfc" required class="form-control uppercase" maxlength="13" minlenght="13">' +
                                        
                                        '<label>Domicilio Fiscal</label>' +
                                        '<input type="text" placeholder="Domicilio Fical" value="'+info.direccion+'" name="domicilio_fiscal" required class="form-control">' +
                                        
                                        '<label>Correo</label>' +
                                        '<input type="text" placeholder="ejemplo@ejemplo.com" value="'+info.correo+'" name="correo" required class="form-control">' +
                                        
                                        '<label>Telefono</label>' +
                                        '<input type="text" placeholder="numero telefonico" value="'+info.telefono+'" name="telefono" maxlength="10" minlenght="10" onkeypress="return solonumeros(event)" required class="form-control">' +
                                        '</form>'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        registrarFactura();
                                    }
                                })
                            }
                        },

                        error: function(error){
                            console.log(error);
                        }
                    })
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    })
});

$('#comision').select2();

function registrarFactura() {
    $.ajax({
        url: '../consultas/crudClientes.php',
        type: 'POST',
        async: true,
        data: $('#registrar_factura').serialize(),

        success: function (response) {
            if (response == 'error') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oopss...',
                    text: 'Algo a salido mal, Intentalo nuevamente'
                });
            } else if (response == 'success') {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Se registro Correctamete el cliente',
                    showConfirmButton: false,
                    timer: 1500
                })

                window.location.href = "../vistas/clientes.php";
            } else if (response == 'factura no registrada') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oopss...',
                    text: 'Algo a salido mal, Intentalo nuevamente',
                    footer: 'Si el error perciste contactar al Programador'
                });
            } else {
                console.log(response);
            }
        }
    })
}