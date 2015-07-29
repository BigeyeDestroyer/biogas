<?php
/**
 * Created by PhpStorm.
 * User: ray
 * Date: 7/29/15
 * Time: 11:30 AM
 */
require_once '../include.php';

$cityname = fetchAll("select id,city from biogas_city");
$num_city = count($cityname);
$cName = array();
$cId = array();
$cGas = array();
$gas_total = 0;
for($i=0;$i<$num_city;$i++){
    $cName[$i]=$cityname[$i]['city'];
    $cGas[$i]=queryTotalGas($cityname[$i]['id']);
    $gas_total = $gas_total + $cGas[$i];
}

$res = array();
foreach ($cName as $k => $r) {
    $res[] = array($cName[$k],$cGas[$k]);
}
$json_res = json_encode($res);
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
                    plotBackgroundColor: null,
                    plotBorderWidth: 1,//null,
                    plotShadow: false
                },
                title: {
                    text: '所有城市沼气产量比例'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                            style: {
                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                            }
                        }
                    }
                },
                series: [{
                    type: 'pie',
                    name: '沼气产量比例',
                    data: <?php echo $json_res;?>/* [
                        ['Firefox',   45.0],
                        ['IE',       26.8],
                        {
                            name: 'Chrome',
                            y: 12.8,
                            sliced: true,
                            selected: true
                        },
                        ['Safari',    8.5],
                        ['Opera',     6.2],
                        ['Others',   0.7]
                    ]*/
                }]
            });
        });


    </script>
</head>
<body>
<script src="../js/highcharts.js"></script>
<script src="../js/modules/exporting.js"></script>

<div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
<div>
    <table align="center">
        <td><?php echo "沼气总产量: ".round($gas_total,2)."立方米"?></td>
    </table>
</div>
</body>
</html>
