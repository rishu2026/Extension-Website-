<?php
require 'vendor/autoload.php';  // Load Google API Client Library

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

    // Load Google Client
    $client = new Client();
    $client->setAuthConfig('your-service-account.json');  // Path to your JSON key file
    $client->addScope(Google\Service\Sheets::SPREADSHEETS);

    // Create Google Sheets Service
    $service = new Sheets($client);
    $spreadsheetId = "17UiVgPtCHTMshdopI1mc3moRSL9BAvWhNvYjNMaZrfU";  // Your Sheet ID
    $range = "Sheet1";  // Your Sheet name

    // Data to insert
    $values = [
        [$extusername, $password, $mobile, $utrid, $days, $amount, $timestamp]
    ];

    $body = new Google\Service\Sheets\ValueRange([
        'values' => $values
    ]);

    $params = ['valueInputOption' => 'USER_ENTERED'];
    $insert = [
        "insertDataOption" => "INSERT_ROWS"
    ];

    // Append data to Google Sheet
    $result = $service->spreadsheets_values->append($spreadsheetId, $range, $body, $params, $insert);

    // Check if successful
    if ($result) {
        echo "<script>alert('Payment Verified! Click OK to Download.'); window.location.href='Tatkal_EXT.zip';</script>";
    } else {
        echo "<script>alert('Error in Payment Verification! Try Again.'); window.history.back();</script>";
    }
} else {
    echo "Invalid request!";
}
?>
