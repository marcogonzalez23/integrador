<?php
require_once("conexion.php");
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <script type="text/javascript">
            setTimeout('document.location.reload()',5000)//especificamos los milisegundos en que la página se recarga
        </script>
		<title>Highcharts Example</title>

		<script type="text/javascript" src="../resources/jquery.js"></script>
		<style type="text/css">
        ${demo.css}
		</style>
		<script type="text/javascript">
    $(function () {
        $('#container').highcharts({
            title: {
                text: 'Estado del contenedor',
                x: -20 //center
            },
            subtitle: {
                text: 'Escala actual',
                x: -20
            },
            xAxis: {
                categories: [
                <?php
                    $sql = " select fecha_hora from tabla_sensor order by id desc limit 10 ";
                    $result = mysqli_query($connection, $sql);
                    while($registros = mysqli_fetch_array($result)){
                        ?>
                            '<?php echo  $registros["fecha_hora"]?>',
                        <?php
                    }
                ?>
                ]
            },
            yAxis: {
                title: {
                    text: 'Datos BMP180'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: ' mb'
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: [
            {   name: '% de comida',
                data: [
                <?php
                    $query = " select presion from tabla_sensor order by id desc limit 10 ";
                    $resultados = mysqli_query($connection, $query);
                    while($rows = mysqli_fetch_array($resultados)){
                        ?>
                            <?php echo $rows["presion"]?>,
                        <?php
                    }
                ?>]
            }
            ]
        });
});
		</script>
	</head>
	<body>
<script src="../resources/highcharts.js"></script>
<script src="../resources/exporting.js"></script>

<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

	</body>
</html>