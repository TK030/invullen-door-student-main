<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Succes</title>
    <link type="image/x-icon" rel="icon" href="https://www.rocmn.nl/themes/custom/rocmn_assets/images/favicons/favicon.ico?v=LbWPk0bBNN">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta http-equiv="refresh" content="5;url=index.php">
</head>

<body>
    <div class="container">
        <div class="alert alert-success mt-5" role="alert">
            <?php
            if (isset($_GET['name'])) {
                echo 'Bedankt, ' . htmlspecialchars($_GET['name']) . '! Je aanvraag is succesvol verstuurd.';
            } else {
                echo 'Je aanvraag is succesvol verstuurd. Je kunt dit tabblad nu sluiten!';
            }
            ?>
        </div>
    </div>
</body>

</html>