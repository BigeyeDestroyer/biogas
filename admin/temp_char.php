<?php
/**
 * Created by PhpStorm.
 * User: ray
 * Date: 7/27/15
 * Time: 6:56 PM
 */
require_once "../include.php";
$id=$_REQUEST['id'];
$arr_res = queryTemp($id);
$username= getNameById($id);

$gas_res = $arr_res[0]; // 沼气产量数组
$d_res = $arr_res[1]; // 日期数组
$gas_total = $arr_res[2]; // 沼气总量
$mid_res = $arr_res[3]; // 平均温度数组
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
                    zoomType: 'xy'
                },
                title: {
                    text: '沼气产量曲线 vs 平均温度曲线'
                },
                subtitle: {
                    text: <?php echo json_encode($username); ?>
                },
                xAxis: [{
                    categories: <?php echo json_encode($d_res); ?>
                }],
                yAxis: [{ // Primary yAxis
                    labels: {
                        format: '{value}°C',
                        style: {
                            color: Highcharts.getOptions().colors[1]
                        }
                    },
                    title: {
                        text: '平均温度',
                        style: {
                            color: Highcharts.getOptions().colors[1]
                        }
                    }
                }, { // Secondary yAxis
                    title: {
                        text: '沼气产量',
                        style: {
                            color: Highcharts.getOptions().colors[0]
                        }
                    },
                    labels: {
                        format: '{value} 立方米',
                        style: {
                            color: Highcharts.getOptions().colors[0]
                        }
                    },
                    opposite: true
                }],
                tooltip: {
                    shared: true
                },
                legend: {
                    layout: 'vertical',
                    align: 'left',
                    x: 60,
                    verticalAlign: 'top',
                    y: 60,
                    floating: true,
                    backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
                },
                series: [{
                    name: '沼气产量',
                    type: 'column',
                    yAxis: 1,
                    data: <?php echo json_encode($gas_res); ?>,
                    tooltip: {
                        valueSuffix: ' 立方米'
                    }

                }, {
                    name: '平均温度',
                    type: 'spline',
                    data: <?php echo json_encode($mid_res); ?>,
                    tooltip: {
                        valueSuffix: '°C'
                    }
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
        <td><?php echo "沼气总产量: ".round($gas_total,2)."立方米"?></td>
        <td>&nbsp;&nbsp;</td>
        <td><?php echo "沼气日均产量: ".round($gas_avg,2)."立方米"?></td>
    </table>
</div>
</body>
</html>
