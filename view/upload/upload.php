<?php

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$fileType = pathinfo($target_file, PATHINFO_EXTENSION);
// Check if file is a actual image or fake image
//if(isset($_POST["submit"])) {
//    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
//    if($check !== false) {
//        echo "File is an image - " . $check["mime"] . ".";
//        $uploadOk = 1;
//    } else {
//        echo "File is not an image.";
//        $uploadOk = 0;
//    }
//}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Il file esiste già.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Il file è troppo grande.";
    $uploadOk = 0;
}
// Allow certain file formats
if ($fileType != "pdf" && $fileType !="p7m") {
    echo "Sono ammessi solo PDF e P7M.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Il file non è stato caricato.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "Il File " . basename($_FILES["fileToUpload"]["name"]) . " è stato caricato.";
    } else {
        echo "Spiacenti, si è verificato un errore.";
    }
}
?> 


//<?php
//
//$stmt = $mysqli->prepare("INSERT INTO messages (message) VALUES (?)");
//$null = NULL;
//$stmt->bind_param("b", $null);
//$fp = fopen("messages.txt", "r");
//while (!feof($fp)) {
//    $stmt->send_long_data(0, fread($fp, 8192));
//}
//fclose($fp);
//$stmt->execute();
//?>
