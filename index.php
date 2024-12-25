<?php
// PDO bağlantısı için gerekli bilgiler
$servername = "localhost";
$username = "oyun1";
$password = "Keles1905.";
$dbname = "oyun1"; // Veritabanı adı

try {
    // PDO ile veritabanına bağlanma
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    
    // Hata modunu istisna olarak ayarla
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Top 3 skoru çekme sorgusu
    $sql = "SELECT player_name, score FROM scores ORDER BY score DESC LIMIT 10";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    // Verileri çekme
    $topScores = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Bağlantı başarısız: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balık Yakalama Oyunu - Giriş</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { font-family: Arial, sans-serif; }
        .container { margin-top: 30px; }
        .form-container { background-color: #f8f9fa; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 10px rgba(0,0,0,0.1); }
        .top-scores-container { background-color: #e9ecef; padding: 20px; margin-top: 30px; border-radius: 10px; box-shadow: 0px 4px 10px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Balık Yakalama Oyunu - Giriş</h1>
        <div class="row justify-content-center">
            <div class="col-md-6 form-container">
                <form id="gameSettingsForm">
                    <div class="form-group">
                        <label for="player_name">Adınızı Girin:</label>
                        <input type="text" class="form-control" id="player_name" placeholder="Adınızı girin" required />
                    </div>
                    <div class="form-group">
                        <label for="fishSpeed">Balık Hızı:</label>
                        <input type="number" class="form-control" id="fishSpeed" value="5" min="1" />
                    </div>
                    <div class="form-group">
                        <label for="boatSpeed">Tekne Hızı:</label>
                        <input type="number" class="form-control" id="boatSpeed" value="5" min="1" />
                    </div>
                    <div class="form-group">
                        <label for="gameDuration">Süre (sn):</label>
                        <input type="number" class="form-control" id="gameDuration" value="60" min="10" />
                    </div>
					Yeşil balık 1 puan 
					Kırmızı balık 2 puan
					turuncu balık 3 puan
					mor balık 4 puan
					yıldız  10 puan
                    <button type="submit" class="btn btn-primary btn-block">Oyuna Başla</button>
                </form>
            </div>
        </div><div class="top-scores-container">
			<h4 class="text-center">Top 10 Skorlar</h4>
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>#</th>
						<th>Oyuncu Adı</th>
						<th>Skor</th>
					</tr>
				</thead>
				<tbody>
                    <?php
                    // Eğer veriler varsa tabloyu doldur
                    if ($topScores) {
                        foreach ($topScores as $index => $score) {
                            echo "<tr>
                                    <td>" . ($index + 1) . "</td>
                                    <td>" . htmlspecialchars($score['player_name']) . "</td>
                                    <td>" . htmlspecialchars($score['score']) . "</td>
                                  </tr>";
                        }
                    } else {
                        // Eğer veri yoksa
                        echo "<tr><td colspan='3' class='text-center'>Henüz skor yok.</td></tr>";
                    }
                    ?>
                </tbody>
			</table>
		</div>

        <!-- Top Scores Bölümü -->
        
    </div>

    <!-- Bootstrap JS ve jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Giriş formu gönderildiğinde
        document.getElementById('gameSettingsForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const playerName = document.getElementById("player_name").value;
            const fishSpeed = document.getElementById("fishSpeed").value;
            const boatSpeed = document.getElementById("boatSpeed").value;
            const gameDuration = document.getElementById("gameDuration").value;

            // Eğer ad boşsa uyarı ver
            if (playerName.trim() === "") {
                alert("Lütfen adınızı girin!");
                return;
            }

            // Ayarları URL parametreleri olarak oyun ekranına geç
            window.location.href = `game.html?name=${playerName}&fishSpeed=${fishSpeed}&boatSpeed=${boatSpeed}&gameDuration=${gameDuration}`;
        });


    // Sayfa yüklendiğinde skorları yükle
    window.onload = loadTopScores;
    </script>
</body>
</html>
