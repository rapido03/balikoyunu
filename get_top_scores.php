<?php
$servername = "localhost";
$username = "oyun1";
$password = "x.";
$dbname = "oyun1";

// Veritabanı bağlantısı
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantı kontrolü
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Veritabanına bağlanıldı!";
}

$sql = "SELECT player_name, score FROM scores ORDER BY score DESC LIMIT 10";
$result = $conn->query($sql);

$scores = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $scores[] = $row;
    }
} else {
    $scores = ["message" => "Henüz skor yok."];
}

$conn->close();

echo json_encode($scores);
?>
