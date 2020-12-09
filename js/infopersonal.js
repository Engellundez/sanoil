$(document).ready(function () {
    $('.cambiar_contrasena').click(function(e){
        Swal.fire({
            title: '<h1 class="modalh1 my-3">Cambiar Contraseña</h1>',
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'Actualizar',
            cancelButtonText: 'Cancelar',
            html:
            '<form action="" id="form_cambiar_contrasena">'+
                '<label>Contraseña Actual</label>'+
                '<input type="password" name="contrasenia" class="form-control">'+
                '<label>Contraseña Nueva</label>'+
                '<input type="password" name="nueva_contrasenia" class="form-control">'+
                '<label>Repite la Contraseña Nueva</label>'+
                '<input type="password" name="repite_nueva_contrasenia" class="form-control">'+
            '</form>'
        }).then((result) => {
            if(result.isConfirmed){
                var data = $('#form_cambiar_contrasena').serialize();
                var datos = data+'&action=actualizar%20contrasena';
                // console.log(datos);
                $.ajax({
                    url: '../consultas/crudUsuarios.php',
                    type: 'POST',
                    async: true,
                    data: datos,
    
                    success: function (response) {
                        if (response == 'error') {
                            console.log(response);
                        } else if(response == 'vacio'){
                            Swal.fire({
                                icon: 'error',
                                title: 'Oopss...',
                                text: 'Dejaste campos vacios'
                            })
                        } else if(response == 'la contraseña no es correcta'){
                            Swal.fire({
                                icon: 'error',
                                title: 'Oopss...',
                                text: 'Tu antigua contraseña no es correcta'
                            })
                        } else if(response == 'no son iguales'){
                            Swal.fire({
                                icon: 'error',
                                title: 'Oopss...',
                                text: 'Las contraseñas no son iguales'
                            })
                        } else if(response == 'son iguales'){
                            Swal.fire({
                                icon: 'error',
                                title: 'Oopss...',
                                text: 'La nueva contraseña es igual a la anterior y no se actualizo'
                            })
                        } else if(response == 'no registro'){
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'No se pudo Actualizar, Recarga la pagina y vuelve a intentarlo',
                                footer: 'Si el error persiste, contactar al Programador'
                            })
                        } else if(response == 'success'){
                            swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'La contraseña funcióna correctamente',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        } else {
                            console.log(response);
                        }
                    },
    
                    error: function (error){
                        console.log(error);
                    }
                })
            }
        })
    });
});
