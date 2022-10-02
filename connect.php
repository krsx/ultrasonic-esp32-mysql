<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
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
    echo '<table cellspacing="5" cellpadding="5">
        <tr> 
          <td>ID</td> 
          <td>Hasil Pengukuran (cm)</td>
          <td>Timestamp</td> 
        </tr>';

    if ($result = $connection->query($sql)) {
        while ($row = $result->fetch_assoc()) {
            $row_id = $row['id'];
            $row_hasil_pengukuran = $row['hasil_pengukuran'];
            $row_timestamp = $row['timestamp'];
            echo '<tr> 
                    <td>' . $row_id . '</td> 
                    <td>' . $row_hasil_pengukuran . '</td> 
                    <td>' . $row_timestamp . '</td> 
                 </tr>';
        }
        $result->free();
    }
    $connection->close();
    ?>
    </table>
</body>

</html>