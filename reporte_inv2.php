<?php
//session_start();
//if(!isset($_SESSION["user_id"]) || $_SESSION["user_id"]==null){
//  print "<script>alert(\"Acceso invalido!\");window.location='login.php';</script>";
//}
?>
<?php require("php/navbar.php"); ?> 
<script>
$(function () {
    Highcharts.chart('container', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Mejores 5 Inversionistas'
        },
        subtitle: {
            text: 'Base de Inversionstas'
        },
        xAxis: {
            type: 'category',
            labels: {
                rotation: -45,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Operaciones (cantidad)'
            }
        },
        legend: {
            enabled: false
        },
        tooltip: {
            pointFormat: 'Cantidad Facturas: <b>{point.y:.1f} </b>'
        },
        series: [{
            name: 'Population',
            data: [
                ['Claudio', 6],
                ['Rodrigo', 9],
                ['Italo', 4],
                ['Germán', 10],
                ['Williams', 11],
            ],
            dataLabels: {
                enabled: true,
                rotation: -90,
                color: '#FFFFFF',
                align: 'right',
                format: '{point.y:.1f}', // one decimal
                y: 10, // 10 pixels down from the top
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        }]
    });
});
</script>
<div id="container">
</div> <!--// container -->

</body>
</html>
