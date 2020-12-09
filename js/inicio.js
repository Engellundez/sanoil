$(document).ready(function () {
    // Grafica lineal
    $.ajax({
        url: '../consultas/graficas.php',
        type: 'POST',
        async: true,
        data: {
            action: 'GraficaLineal'
        },

        success: function (responseL) {
            if (responseL == 'error') {
                console.log(responseL);
            }else{
                var xy = responseL.indexOf(" ");
                var lineaX = responseL.substr(0,xy);
                var lineaY = responseL.substr(xy+1);
                lineaX = crarCadenaLineal(lineaX);
                lineaY = crarCadenaLineal(lineaY);

                var linea1 = {
                    x: lineaX,
                    y: lineaY,
                    type: 'scatter',
                    line:{
                        color: '#28a745', //color
                        width: 2
                    },
                    marker: {
                        color: '#28a745', //color
                        size: 12
                    }
                };
                var layout = {
                    title: 'Grafica de Ventas',
                    xaxis:{
                        title: 'Fecha'
                    },
                    yaxis:{
                        zeroline: false,
                        gridwidth: 2,
                        title: 'Monto'
                    }
                };

                var datalineas = [linea1];
                Plotly.newPlot('graficaLineal', datalineas, layout);
            }
        },

        error: function(errorL) {
            console.log(errorL);
        }
    });
    
    // Grafica Barras
    $.ajax({
        url: '../consultas/graficas.php',
        type: 'POST',
        async: true,
        data: {
            action: 'GraficaBarras'
        },

        success: function (responseB) {
            if (responseB == 'error') {
                console.log(responseB);
            }else{
                var xy = responseB.indexOf(" ");
                var barraX = responseB.substr(0,xy);
                var barraY = responseB.substr(xy+1);
                barraX = crarCadenaLineal(barraX);
                barraY = crarCadenaLineal(barraY);

                var databarras = [
                    {
                        x: barraX,
                        y: barraY,
                        type: 'bar',
                        marker: {
                            color: '#007bff' //color
                        }
                    }
                ];
                var layout = {
                    title: 'Producto más Vendido',
                    font: {
                        family: 'Releway, Sans-serif'
                    },
                    xaxis:{
                        tickangle: -45,
                        title: 'Producto'
                    },
                    yaxis:{
                        zeroline: false,
                        gridwidth: 2,
                        title: 'Cantidad'
                    },
                    bargap: 0.05
                };
                Plotly.newPlot('graficaBarras', databarras, layout);
            }
        },

        error: function(errorB) {
            console.log(errorB);
        }
    });
});

function crarCadenaLineal(json){
    var parsed = JSON.parse(json);
    var arr = [];
    for(var x in parsed){
        arr.push(parsed[x]);
    }
    return arr;
}