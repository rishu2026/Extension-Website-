<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $extusername = htmlspecialchars($_POST["extusername"]);
    $password = htmlspecialchars($_POST["password"]);
    $mobile = htmlspecialchars($_POST["mobile"]);
    $utrid = htmlspecialchars($_POST["utrid"]);
    $days = htmlspecialchars($_POST["days"]);
    $amount = htmlspecialchars($_POST["amount"]);
    $timestamp = date("Y-m-d H:i:s");

    // Google Sheets API URL
    $google_sheets_url = "https://sheets.googleapis.com/v4/spreadsheets/17UiVgPtCHTMshdopI1mc3moRSL9BAvWhNvYjNMaZrfU/values/Sheet1:append?valueInputOption=RAW&key=AIzaSyBL2tlF2BAxoil0UXEiyA6I51iOgpOuOkw";

    // Data to send
    $postData = [
        "values" => [
            [$extusername, $password, $mobile, $utrid, $days, $amount, $timestamp]
        ]
    ];

    // Convert to JSON
    $jsonData = json_encode($postData);

    // Send data to Google Sheets
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $google_sheets_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    // Redirect to download the extension
    header("Location: Tatkal_EXT.zip");
    exit();
} else {
    echo "Invalid request!";
}
?>
