<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);
    $mobile = htmlspecialchars($_POST["mobile"]);
    $utr = htmlspecialchars($_POST["utr"]);
    $days = htmlspecialchars($_POST["days"]);
    $amount = htmlspecialchars($_POST["amount"]);

    // Store user data in a file (can be replaced with a database)
    $file = fopen("submissions.txt", "a");
    fwrite($file, "Username: $username | Mobile: $mobile | UTR: $utr | Days: $days | Amount: ₹$amount\n");
    fclose($file);

    // Redirect to extension download page (Make sure extension.zip is uploaded)
    header("Location: extension.zip");
    exit();
} else {
    echo "Invalid request!";
}
?>

