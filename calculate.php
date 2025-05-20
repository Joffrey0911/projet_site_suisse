<?php

header('Content-Type: application/json');

// Connexion base de données
$host = 'localhost';
$dbname = 'trajetsdb';
$user = 'root';
$pass = '';


$apiKey = '';



// Vérification des champs envoyés
if (!isset($_POST['start']) || !isset($_POST['end'])) {
    echo json_encode(['error' => 'Paramètres manquants']);
    exit;
}

$start = htmlspecialchars(trim($_POST['start']), ENT_QUOTES, 'UTF-8');
$end = htmlspecialchars(trim($_POST['end']), ENT_QUOTES, 'UTF-8');


// Fonction pour obtenir les coordonnées GPS à partir d'un nom de ville
function getCoordinates($place, $apiKey) {
    $url = "https://api.openrouteservice.org/geocode/search?api_key=" . $apiKey . "&text=" . urlencode($place) . "&size=1";
    $response = file_get_contents($url);
    if (!$response) return false;
    $data = json_decode($response, true);
    if (isset($data['features'][0]['geometry']['coordinates'])) {
        return $data['features'][0]['geometry']['coordinates']; // format : [lon, lat]
    }
    return false;
}


$startCoords = getCoordinates($start, $apiKey);
$endCoords = getCoordinates($end, $apiKey);

if (!$startCoords || !$endCoords) {
    echo json_encode(['error' => 'Impossible de géocoder les adresses']);
    exit;
}

// Appel à l'API ORS Matrix pour distance et durée
$matrixUrl = "https://api.openrouteservice.org/v2/matrix/driving-car";
$body = json_encode([
    "locations" => [ $startCoords, $endCoords ],
    "metrics" => ["distance", "duration"]
]);

$options = [
    "http" => [
        "header" => "Content-Type: application/json\r\n" .
                    "Authorization: $apiKey\r\n",
        "method" => "POST",
        "content" => $body
    ]
];

$context = stream_context_create($options);
$matrixResponse = file_get_contents($matrixUrl, false, $context);
if (!$matrixResponse) {
    echo json_encode(['error' => 'Erreur lors de l\'appel à l\'API ORS']);
    exit;
}

$data = json_decode($matrixResponse, true);

// Récupération des valeurs
$distance = $data['distances'][0][1]; // en mètres
$duration = $data['durations'][0][1]; // en secondes

// Enregistrement en base de données
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("CREATE TABLE IF NOT EXISTS trajets (
        id INT AUTO_INCREMENT PRIMARY KEY,
        start_location VARCHAR(255),
        end_location VARCHAR(255),
        distance_value INT,
        duration_value INT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    $stmt = $pdo->prepare("INSERT INTO trajets 
        (start_location, end_location, distance_value, duration_value) 
        VALUES (:start, :end, :distance, :duration)");
    
    $stmt->execute([
        ':start' => $start,
        ':end' => $end,
        ':distance' => $distance,
        ':duration' => $duration
    ]);
    
    
    $duration_in_hours = $duration / 3600; // convertit secondes → heures

    
    $duration_text = round($duration_in_hours, 2) . ' h';
    echo json_encode([
        'distance_text' => round($distance / 1000, 2) . ' km',
        'duration_text' => $duration_text
    ]);

} catch (PDOException $e) {
    echo json_encode(['error' => 'Erreur base de données: ' . $e->getMessage()]);
}
