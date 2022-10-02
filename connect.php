<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <title>ESP32-Ultrasonic</title>
</head>
<style>
    body {
        text-align: center;
        font-family: "Poppins", sans-serif;
    }

    .title1 {
        font-size: 38px;
        margin: 25px 0 0 0;
    }

    .title2 {
        margin: 0 0 0 0;
        font-size: 38px;
    }

    .table-style {
        border-collapse: collapse;
        margin: 24px 0;
        font-size: 0.9 em;
        min-width: 500px;
        border-radius: 12px 12px 12px 12px;
        overflow: hidden;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
    }

    .table-style thead tr {
        background-color: #00B4D8;
        color: #FFFFFF;
        text-align: center;
    }

    .table-style th,
    .table-style td {
        padding: 12px 15px;
    }

    .table-style tbody tr {
        border-bottom: 1px solid #dddddd;
    }
</style>

<body>
    <h1 class="title1">IMPLEMENTASI ESP32</h1>
    <h1 class="title2">SENSOR ULTRASONIC HC-SR04</h1>

    <?php
    function connection()
    {
        $servername = 'localhost';
        $username = 'root';
        $password = '';
        $database_name = 'db_ultrasonic_esp32';

        $connection = new mysqli($servername, $username, $password, $database_name);

        return $connection;
    }
    if (isset($_GET["hasil_pengukuran"])) {
        $hasil_pengukuran = $_GET["hasil_pengukuran"];

        $connection = connection();

        if ($connection->connect_error) {
            die("MySQL connection failed: " . $connection->connect_error);
        }
        $sql = "INSERT INTO tbl_pengukuran (hasil_pengukuran) VALUES  ($hasil_pengukuran)";

        if ($connection->query($sql) == TRUE) {
            echo "Record data baru " . $hasil_pengukuran . " berhasil ditambahkan";
        } else {
            echo "Error: " . $sql . "=>" . $connection->error;
        }
    }
    // else {
    //     echo "Hasil pengukuran (jarak) masih belum set pada HTTP request";
    // }

    $connection = connection();

    $sql = 'SELECT * FROM tbl_pengukuran  ORDER BY id DESC';
    echo '<table class="table-style" style="margin-left:auto;margin-right:auto;">
        <thead>
            <tr> 
                <th>ID</th> 
                <th>Hasil Pengukuran (cm)</th>
                <th>Timestamp</th> 
            </tr>
        </thead>';

    if ($result = $connection->query($sql)) {
        while ($row = $result->fetch_assoc()) {
            $row_id = $row['id'];
            $row_hasil_pengukuran = $row['hasil_pengukuran'];
            $row_timestamp = $row['timestamp'];
            echo '
            <tbody>
                <tr> 
                    <td>' . $row_id . '</td> 
                    <td>' . $row_hasil_pengukuran . '</td> 
                    <td>' . $row_timestamp . '</td> 
                 </tr>
            </tbody>';
        }
        $result->free();
    }
    $connection->close();
    ?>
    </table>
</body>

</html>