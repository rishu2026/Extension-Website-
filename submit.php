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
$google_sheets_url = "https://sheets.googleapis.com/v4/spreadsheets/17UiVgPtCHTMshdopI1mc3moRSL9BAvWhNvYjNMaZrfU/values/Sheet1:append?valueInputOption=USER_ENTERED";

$headers = [
    "Content-Type: application/json",
    "Authorization: Bearer YOUR_ACCESS_TOKEN"  // Replace with a valid access token
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $google_sheets_url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(["values" => [[$extusername, $password, $mobile, $utrid, $days, $amount, $timestamp]]]));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

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

    // Check if data is successfully added to Google Sheets
    if ($response) {
        echo "<script>alert('Payment Verified! Click OK to Download.'); window.location.href='Tatkal_EXT.zip';</script>";
    } else {
        echo "<script>alert('Error in Payment Verification! Try Again.'); window.history.back();</script>";
    }
} else {
    echo "Invalid request!";
}
?>
