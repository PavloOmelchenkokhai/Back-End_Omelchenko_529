<?php

// TODO 1: обробка GET запиту

$items = [];

if (isset($_GET['search']) && !empty($_GET['search'])) {

    $search = $_GET['search'];

    $apiKey = "30aef2622eb295dff88623fb37c400036d663755";

    $url = "https://google.serper.dev/search";

    // формуємо JSON
    $postData = json_encode([
            "q" => $search
    ]);

    // CURL запит
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "X-API-KEY: $apiKey",
            "Content-Type: application/json"
    ]);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

    $response = curl_exec($ch);

    curl_close($ch);

    // декодуємо JSON
    $data = json_decode($response, true);

    // Serper використовує 'organic'
    if (isset($data['organic'])) {
        $items = $data['organic'];
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Browser</title>
</head>

<body>

<h2>My Browser</h2>

<form method="GET" action="/webSearch/index.php">

    <label for="search">Search:</label>

    <input type="text" id="search" name="search" value="">

    <br><br>

    <input type="submit" value="Submit">

</form>

<hr>

<?php

// TODO 2: відображення результатів

foreach ($items as $item) {

    echo "<h3>".$item['title']."</h3>";

    echo "<a href='".$item['link']."'>".$item['link']."</a>";

    echo "<p>".$item['snippet']."</p>";

    echo "<hr>";
}

?>

</body>
</html>