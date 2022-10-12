<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="5">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">

    <title>Grafik ESP32 - Ultrasonic HC-SR04</title>
</head>
<style>
    body {
        font-family: "Poppins", sans-serif;
        text-align: center;
    }

    .grafik {
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.08);
    }

    .title1 {
        font-family: "Poppins", sans-serif;
        font-size: 44px;
        margin: 25px 0 0 0;
    }

    .title2 {
        font-family: "Poppins", sans-serif;
        margin: 0 0 100px 0;
        font-size: 44px;
    }
</style>

<body>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <h1 class="title1">GRAFIK IMPLEMENTASI ESP32</h1>
    <h1 class="title2">SENSOR ULTRASONIC HC-SR04</h1>
    <div id='chart_div' class="grafik"></div>
    <script>
        google.charts.load('current', {
            packages: ['corechart', 'line']
        });
        google.charts.setOnLoadCallback(drawBasic);

        function drawBasic() {
            var data = new google.visualization.DataTable();
            data.addColumn('number', 'X');
            data.addColumn('number', 'Sensor 1');
            data.addRows([
                <?php
                $servername = 'localhost';
                $username = 'root';
                $password = '';
                $database_name = 'db_ultrasonic_esp32';
                $connection = new mysqli($servername, $username, $password, $database_name);
                $query = "SELECT id,hasil_pengukuran FROM tbl_pengukuran ORDER BY id DESC LIMIT 20;";
                $tampil = mysqli_query($connection, $query);
                while ($data = mysqli_fetch_array($tampil)) {
                    print "[" . $data['id'] . "," . $data['hasil_pengukuran'] . "], ";
                }
                ?>
            ]);
            var options = {
                hAxis: {
                    title: 'ID'

                },
                vAxis: {
                    title: 'Jarak (cm)'
                },
                //curveType: 'function',
                colors: ['#A020F0', '#097138'],
                lineWidth: 3,
            };

            var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
    </script>
</body>

</html>