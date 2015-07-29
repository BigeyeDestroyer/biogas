<?php
/**
 * Created by PhpStorm.
 * User: ray
 * Date: 7/27/15
 * Time: 6:56 PM
 */
require_once "../include.php";
$id=$_REQUEST['id'];
$arr_res = queryTempCity($id);
$city= getCityById($id)['city'];

$gas_res = $arr_res[0];
$d_res = $arr_res[1];
$gas_total = $arr_res[2];
$gas_avg = $gas_total/count($d_res);
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Highcharts Example</title>

    <script type="text/javascript" src="http://cdn.hcharts.cn/jquery/jquery-1.8.2.min.js"></script>
    <style type="text/css">
        ${demo.css}
    </style>
    <script type="text/javascript">
        $(function () {
            $('#container').highcharts({
                chart: {
                    type: 'line'
                },
                title: {
                    text: <?php echo json_encode($city."沼气产量曲线"); ?>
                },
                xAxis: {
                    categories: <?php echo json_encode($d_res); ?>
                },
                yAxis: {
                    title: {
                        text: '沼气产量 (m^3)'
                    }
                },
                plotOptions: {
                    line: {
                        dataLabels: {
                            enabled: true
                        },
                        enableMouseTracking: false
                    }
                },
                series: [{
                    name: <?php echo json_encode($city); ?>,
                    data: <?php echo json_encode($gas_res); ?>
                }]
            });
        });

    </script>
</head>
<body>
<script src="../js/highcharts.js"></script>
<script src="../js/modules/exporting.js"></script>

<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<div>
    <table align="center">
        <td><?php echo "沼气总产量: ".round($gas_total,2)?></td>
        <td>&nbsp;&nbsp;</td>
        <td><?php echo "沼气日均产量: ".round($gas_avg,2)?></td>
    </table>
</div>
</body>
</html>
