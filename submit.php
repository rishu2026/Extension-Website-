<?php

require 'vendor/autoload.php';

use Google\Client;
use Google\Service\Sheets;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $extusername = htmlspecialchars($_POST["extusername"]);
    $password = htmlspecialchars($_POST["password"]);
    $mobile = htmlspecialchars($_POST["mobile"]);
    $utrid = htmlspecialchars($_POST["utrid"]);
    $days = htmlspecialchars($_POST["days"]);
    $amount = htmlspecialchars($_POST["amount"]);
    $timestamp = date("Y-m-d H:i:s");

    // Path to the Service Account JSON Key File
    $jsonKeyFilePath = 'alpine-furnace-440410-c6-117c00895ac6.json'; // Update with your actual file path

    // Google Sheets Details
    $spreadsheetId = '17UiVgPtCHTMshdopI1mc3moRSL9BAvWhNvYjNMaZrfU'; // Your Google Sheet ID
    $range = 'Sheet1!A:G'; // Adjust according to your sheet structure

    // Authenticate with Google Sheets API
    $client = new Client();
    $client->setAuthConfig($jsonKeyFilePath);
    $client->addScope(Sheets::SPREADSHEETS);

    $service = new Sheets($client);

    // Data to append
    $values = [
        [$extusername, $password, $mobile, $utrid, $days, $amount, $timestamp]
    ];

    $body = new Google\Service\Sheets\ValueRange([
        'values' => $values
    ]);

    $params = ['valueInputOption' => 'USER_ENTERED'];

    // Append data to the Google Sheet
    try {
        $service->spreadsheets_values->append($spreadsheetId, $range, $body, $params);
        echo "<script>alert('Payment Verified! Click OK to Download.'); window.location.href='Tatkal_EXT.zip';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "'); window.history.back();</script>";
    }
} else {
    echo "Invalid request!";
}
?>
