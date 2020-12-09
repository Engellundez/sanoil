$(document).ready(function () {
    // AGREGAR PRODUCTO (llamando Sweetalert)
    $('.agregar_producto').click(function (e) {
        e.preventDefault();
        Swal.fire({
            title: '<h1 class="my-2 modalh1">Agregar Nuevo Producto</h1>',
            showCancelButton: true,
            cancelButtonColor: '#dc3545',
            cancelButtonText: 'Cancelar',
            showConfirmButton: true,
            confirmButtonColor: '#28a745',
            confirmButtonText: 'Agregar Producto',
            html: 
            '<form class="formModal" action="" method="POST" name="form_agregar_producto" id="form_agregar_producto" onsubmit="event.preventDefault(); sendNewDataProduct();" align="center">' +

                '<label for="nombre">Nombre</label>' +
                '<input type="text" name="nombre_producto" id="nombre" value="" required class="form-control my-1 initial" placeholder="Nombre del Producto">' +

                '<label for="codigo_producto">Codigo</label>' +
                '<input type="text" name="codigo_producto" id="codigo_producto"  value="" required class="form-control my-1 uppercase" placeholder="Codigo del Producto">' +

                '<label for="descripcion">Descripcion</label>' +
                '<input type="text" name="descripcion" id="descripcion" value="" required class="form-control my-1 initial" placeholder="Descripcion del Producto">' +

                '<label for="precio">Precio</label>' +
                '<input type="text" name="precio" id="precio" value="" required class="form-control my-1" onkeypress="return solonumeros_Punto(event)" placeholder="Precio del Producto">' +

                '<label for="cantidad">Cantidad</label>' +
                '<input type="text" name="cantidad" id="cantidad" value="" required class="form-control my-1" onkeypress="return solonumeros(event)" placeholder="Cantidad del Producto">' +

                '<label>Mililitros</label>'+
                '<input type="text" name="mililitros" id="miligramos" value="" required class="form-control my-1" onkeypress="return solonumeros_Punto(event)" placeholder="Mililitros que contiene el producto 1 = 1 litro y .6 = 600 mililitros">'+

                '<input type="hidden" name="action" value="Guardar_nuevo_producto" required>' +
            '</form>'
        }).then((result) => {
            if (result.isConfirmed) {
                sendNewDataProduct();
            }
        })
    });

    // EDITAR EL PRODUCTO
    $('.editar_producto').click(function (event) {
        event.preventDefault();
        console.log("entra");
        var IdProducto = $(this).attr('id_producto');
        var Nombre = $(this).attr('nombre_producto');
        var action = 'Passwordforeditquery';
        // ajax solicitando datos
        $.ajax({
            url: '../consultas/crudProductos.php',
            type: 'POST',
            async: true,
            // enviar datos 1 x 1 
            data: {
                action: action,
                producto_Id: IdProducto
            },
            success: function (response) {
                if (response != 'error') {
                    var info = JSON.parse(response);
                    Swal.fire({
                        title: '<h1 class="my-2 modalh1">¿Editar el producto "' + Nombre + '"?</h1>',
                        showCancelButton: true,
                        cancelButtonColor: '#dc3545',
                        cancelButtonText: 'Cancelar',
                        showConfirmButton: true,
                        confirmButtonColor: '#ffc107',
                        confirmButtonText: 'Editar Producto',
                        html: 
                        '<form class="formModal" action="" method="POST" name="form_editar_producto" id="form_editar_producto" onsubmit="event.preventDefault(); sendDataProduct();">' +
                            '<h2 class="nameProducto" align="center">' + info.nombre_producto + '</h2>' +
                            '<input type="hidden" name="producto_id" id="producto_id" value="' + info.id + '" required>' +

                            '<label for="producto">Nombre</label>' +
                            '<input class="form-control my-1 initial" type="text" name="nombre_producto" id="nombre_producto" value="' + info.nombre_producto + '" placeholder="Nombre del producto" required>' +

                            '<label for="codigo_producto">Codígo</label>' +
                            '<input class="form-control my-1 uppercase" type="text" name="codigo_producto" id="codigo_producto" value="' + info.codigo_producto + '" placeholder="Codígo del producto" required>' +

                            '<label for="descripcion">Descripción</label>' +
                            '<input class="form-control my-1 initial" type="text" name="descripcion" id="descripcion" value="' + info.descripcion + '" placeholder="Descripción del producto" required>' +

                            '<label for="precio">Precio</label>' +
                            '<input class="form-control my-1" type="number" name="precio" id="precio" value="' + info.precio + '" onkeypress="return solonumeros(event)" placeholder="Precio del producto" required>' +

                            '<label for="cantidad">Cantidad</label>' +
                            '<input class="form-control my-1" type="number" name="cantidad" id="cantidad" value="' + info.cantidad + '" onkeypress="return solonumeros(event)" placeholder="Cantidad" required>' +

                            '<label>Mililitros</label>' +
                            '<input type="text" name="mililitros" id="miligramos" value="'+ info.mililitros +'" required class="form-control my-1" onkeypress="return solonumeros_Punto(event)" placeholder="Mililitros que contiene el producto 1 = 1 litro y .6 = 600 mililitros">'+
                            

                            '<input type="hidden" name="action" value="EditProductforsustitution" id="action" required>' +

                        '</form>'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            sendDataProduct();
                        }
                    })
                }
            },
            error: function (error) {
                console.log(error);
            }
        });

    });

    // Eliminar Producto
    $('.eliminar_Producto').click(function (e) {
        e.preventDefault();
        var IdProducto = $(this).attr('id_producto');
        var action = "Passwordfordeletequery";
        var Nombre = $(this).attr('nombre_producto');
        Swal.fire({
            title: '¿Seguro que deseas borrar el producto "' + Nombre + '"?',
            text: "¡Recuerda que no podras revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, ¡Eliminar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                EliminarProducto(IdProducto, action);
            }
        })
    });

    // agregar cantidad
    $('.agregar_cantidad').click(function(e){
        e.preventDefault();
        var IdProducto = $(this).attr('id_producto');
        var Nombre = $(this).attr('nombre_producto');
        Swal.fire({
            title: '<h1 class="my-2 modalh1">Agregar cantidad a "' + Nombre + '"</h1>',
            showCancelButton: true,
            cancelButtonColor: '#dc3545',
            cancelButtonText: 'Cancelar',
            showConfirmButton: true,
            confirmButtonColor: '#28a745',
            confirmButtonText: 'Agregar',
            html: '<form class="formModal" action="" method="POST" name="form_agregar_cantidad" id="form_agregar_cantidad" onsubmit="event.preventDefault();" align="center">' +

                '<label for="cantidad">Cantidad</label>' +
                '<input type="number" name="cantidad" id="cantidad" value="" required class="form-control my-1" onkeypress="return solonumeros(event)" placeholder="cantidad a agregar">' +

                '<input type="hidden" name="action" value="Agregar_cantidad" required>' +

                '<input type="hidden" name="IdProducto" value="' + IdProducto + '" required>' +
                '</form>'
        }).then((result) => {
            if (result.isConfirmed) {
                var datos = $('#form_agregar_cantidad').serialize();
                // console.log(datos);
                $.ajax({
                    url: '../consultas/crudProductos.php',
                    type: 'POST',
                    async: true,
                    data: datos,

                    success: function(response){
                        if(response == 'error'){
                            console.log(response);
                        }else if(response == 'menor'){
                            Swal.fire({
                                icon: 'error',
                                title: 'Oopss...',
                                text: 'La cantidad a agregar no puede ser menor a 0 (zero)'
                            })
                        }else if(response == 'no se guardo'){
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Recarga la página y vuelve a intentarlo',
                                footer: 'Si el error continua llamar al programador'
                            })
                        }else if(response == 'success'){
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Cantidad Agregada',
                                showConfirmButton: false,
                                timer: 1500
                            })

                            location.reload();
                        }else{
                            console.log(response);
                        }
                    }
                })
            }
        })
    });

});

function sendNewDataProduct() {
    // Enviamos los datos para agregarlos
    $.ajax({
        url: '../consultas/crudProductos.php',
        type: 'POST',
        async: true,
        data: $('#form_agregar_producto').serialize(),

        success: function (response) {
            if (response == "error") {
                console.log(response);
            } else if(response == "success") {
                // recargamos la tabla
                location.reload();

                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Se guardo correctamente el producto',
                    showConfirmButton: false,
                    timer: 1500
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

function sendDataProduct() {
    // enviamos los datos editados
    $.ajax({
        url: '../consultas/crudProductos.php',
        type: 'POST',
        async: true,

        // enviar datos de golpe con el id del form
        data: $('#form_editar_producto').serialize(),

        success: function (response) {
            if (response == "error") {
                console.log('error');
            } else if(response == "success"){
                location.reload();
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Se edito correctamente el Producto',
                    showConfirmButton: false,
                    timer: 1500
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

function EliminarProducto(id, action) {
    // enviamos datos para eliminación
    $.ajax({
        url: '../consultas/crudProductos.php',
        type: 'POST',
        async: true,
        data: {
            action: action,
            id: id,
        },
        success: function (response) {

            if (response == 'success') {
                location.reload();
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Se elimino correctamente el producto',
                    showConfirmButton: false,
                    timer: 1500
                })
            } else if(response == 'datos vacio'){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '¡Algo salio mal!',
                    footer: 'Si el error continua, favor de llamar al programador'
                })
            }else {
                console.log(response);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '¡Algo salio mal!',
                    footer: 'Si el error continua, favor de llamar al programador'
                })
            }
        },
        error: function (error) {
            console.log(error);
        }
    })
}

function Actualizar_formulario(){
    var id_embasado = document.getElementById("envasado_id").value;
    $.ajax({
        url: '../consultas/crudProductos.php',
        type: 'POST',
        async: true,
        data: {
            action: 'Realizar cambio',
            id_embasado: id_embasado
        },

        success: function (response) {
            if (response == 'error') {
                console.log("error");
            }else if (response == 'vacio'){
                $('.nombre').html('<input type="text" name="nombre" id="nombre" value="" disabled class="form-control my-1 initial" placeholder="Nombre del Producto">');
                $('.codigo_producto').html('<input type="text" name="codigo_producto" id="codigo_producto" value="" disabled class="form-control my-1 uppercase" placeholder="Codigo del Producto">');
                $('.descripcion').html('<input type="text" name="descripcion" id="descripcion" value="" disabled class="form-control my-1 initial" placeholder="Descripcion del Producto">');
                $('.ml_o_l').html('<input type="number" name="ml_o_l" id="ml_o_l" value="" disabled class="form-control my-1" onkeypress="return solonumeros_Punto(event)" placeholder="Cantidad en litros (1 = 1 litro) y (.600 = 600 ml)">');
                $('.precio').html('<input type="number" name="precio" id="precio" value="" disabled class="form-control my-1" onkeypress="return solonumeros(event)" placeholder="Precio del Producto">');
            }else if(response == 'success'){
                $('.nombre').html('<input type="text" name="nombre" id="nombre" value="" required class="form-control my-1 initial" placeholder="Nombre del Producto">');
                $('.codigo_producto').html('<input type="text" name="codigo_producto" id="codigo_producto" value="" required class="form-control my-1 uppercase" placeholder="Codigo del Producto">');
                $('.descripcion').html('<input type="text" name="descripcion" id="descripcion" value="" required class="form-control my-1 initial" placeholder="Descripcion del Producto">');
                $('.ml_o_l').html('<input type="number" name="ml_o_l" id="ml_o_l" value="" required class="form-control my-1" onkeypress="return solonumeros_Punto(event)" placeholder="Cantidad en litros (1 = 1 litro) y (.600 = 600 ml)">');
                $('.precio').html('<input type="number" name="precio" id="precio" value="" required class="form-control my-1" onkeypress="return solonumeros(event)" placeholder="Precio del Producto">');
            }else{
                console.log(response);
            }
        },
        error: function (error) {
            console.log(error);
        }
    })
}