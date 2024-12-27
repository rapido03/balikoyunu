
<?php
// Hata mesajlarını göstermek için
ini_set('display_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "oyun1";
$password = "x.";
$dbname = "oyun1"; // Veritabanı adını değiştirebilirsiniz
// Veritabanı bağlantısı
$conn = new mysqli($servername, $username, $password, $dbname);
// Bağlantı kontrolü
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// POST ile gelen verileri kontrol et
if (isset($_POST['name']) && isset($_POST['score'])) {
    $name = $_POST['name'];
    $score = $_POST['score'];
    // Verilerin doğru alındığını kontrol et
    error_log("Veriler: Name = $name, Score = $score");
    // Veritabanına veri ekleme
    $stmt = $conn->prepare("INSERT INTO scores (player_name, score) VALUES (?, ?)");
    $stmt->bind_param("si", $name, $score);
    if ($stmt->execute()) {
        // Başarıyla kaydedildi
        echo "Score successfully saved!";
    } else {
        // Hata mesajı
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Error: Missing name or score data.";
}
$conn->close();
?>
