<?php
require_once 'db_connect.php';
require_once 'vendor/autoload.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $naamStudent = $_POST["naamStudent"];
    $studentNum = $_POST["studentNum"];
    $examenNamen = isset($_POST["examenNaam"]) ? $_POST["examenNaam"] : [];
    $examenCodes = isset($_POST["examenCode"]) ? $_POST["examenCode"] : [];
    $bewijs = (isset($_POST["bewijs"]) && $_POST["bewijs"] == "ja") ? uploadFile() : "nee";

    if (count($examenNamen) != count($examenCodes)) {
        echo "Error: The number of exam names and codes do not match.";
    } else {
        $query =
            "INSERT INTO aanvraag (naamStudent, studentNum, bewijs) 
                  VALUES (:naamStudent, :studentNum, :bewijs)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':naamStudent', $naamStudent);
        $stmt->bindParam(':studentNum', $studentNum);
        $stmt->bindParam(':bewijs', $bewijs);
        $stmt->execute();

        $primaryKey = $conn->lastInsertId();

        foreach ($examenCodes as $index => $code) {
            $query =
                "INSERT INTO aanvraag_examens (examenNaam, examenCode, aanvraag_id) 
                      VALUES (:examenNaam, :examenCode, :aanvraag_id)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':examenNaam', $examenNamen[$index]);
            $stmt->bindParam(':examenCode', $code);
            $stmt->bindParam(':aanvraag_id', $primaryKey);
            $stmt->execute();
        }

        // Redirect naar send.php om de e-mail te verzenden
        header('Location: send.php?file=' . urlencode($bewijs) . '&name=' . urlencode($naamStudent) . '&bewijs=' . urlencode($_POST['bewijs']));
        exit;
    }
}

function uploadFile()
{
    if (isset($_FILES['bewijs'])) {
        $file = $_FILES['bewijs'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileType = $file['type'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowed = ['pdf', 'jpeg', 'png', 'doc', 'docx'];

        if (in_array($fileExt, $allowed)) {
            if ($fileSize <= 3000000) { // kan max 3 mb aan bestanden uploaden
                $fileNameNew = uniqid('', true) . "." . $fileExt;
                $fileDestination = 'uploads/' . $fileNameNew;

                if (move_uploaded_file($fileTmpName, $fileDestination)) {
                    return $fileDestination;
                } else {
                    echo "Sorry, there was an error moving the uploaded file.";
                }
            } else {
                echo "Sorry, your file is too large.";
            }
        } else {
            echo "Sorry, only PDF, JPEG, PNG, DOC, and DOCX files are allowed.";
        }
    }
    return null;
}
