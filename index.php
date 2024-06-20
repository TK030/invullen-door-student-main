<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vrijstelling Aanvraag</title>
    <link type="image/x-icon" rel="icon" href="https://www.rocmn.nl/themes/custom/rocmn_assets/images/favicons/favicon.ico?v=LbWPk0bBNN">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 20px;
            background-color: #f0f0f0;
        }

        .form-label.required:after {
            content: "*";
            color: red;
            margin-left: 4px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .form-check-input:checked+.form-check-label:before {
            background-color: #007bff;
            border-color: #007bff;
        }

        .select-container {
            margin-bottom: 10px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .col {
            flex: 1;
            min-width: 300px;
        }

        .tooltip-inner {
            background-color: #d0e7ff !important;
            color: #000;
            border: 1px solid #007bff;
        }

        .tooltip-arrow::before {
            border-top-color: #d0e7ff !important;
        }
    </style>
</head>

<body>
    <div class="container">
        <header class="mb-3">
            <h1>Vrijstelling Aanvraag</h1>
            <p class="lead">Je kan meer dan 1 vrijstelling tegelijk aanvragen. Vul dan de namen en codes achter elkaar in.</p>
        </header>
        <form action="upload.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="naamStudent" class="form-label required">Student Naam:</label>
                <input type="text" class="form-control" id="naamStudent" name="naamStudent" autocomplete="off" required>
            </div>
            <div class="mb-3">
                <label for="studentNum" class="form-label required">Studentnummer:</label>
                <input type="number" class="form-control" id="studentNum" name="studentNum" autocomplete="off" required>
            </div>
            <div id="examContainer">
                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label required">Naam Examen:</label>
                        <div class="input-group select-container">
                            <input type="text" class="form-control" name="examenNaam[]" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="col">
                        <label class="form-label required">Code Examen:</label>
                        <div class="input-group select-container">
                            <input type="text" class="form-control" name="examenCode[]" autocomplete="off" required>
                            <button type="button" class="btn btn-primary add-btn" data-bs-toggle="tooltip" title="Wil je meerdere examens toevoegen? Klik dan hier!" onclick="addExamFields()">+</button>
                        </div>
                    </div>
                </div>
            </div>
            <h2 class="mb-3">Welk bewijs stuur je mee?</h2>
            <p class="lead">Een uittreksel uit het diplomaregister van DUO (<a href="http://www.duo.nl/" target="_blank">www.duo.nl</a>) in pdf en een kopie van je gewaarmerkte resultatenlijst die je bij je diploma hebt ontvangen of een kopie van je behaalde diploma en een kopie van je resultatenlijst. Als je het examen recent bij het ROC Midden Nederland hebt behaald, hoef je geen bewijs mee te sturen.</p>
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="bewijs" id="bewijsja" value="ja" onclick="bewijsMeeSturen()">
                    <label class="form-check-label lead" for="bewijsja">Ik stuur bewijs mee, namelijk:</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="bewijs" id="bewijsnee" value="nee" onclick="bewijsMeeSturen()">
                    <label class="form-check-label lead" for="bewijsnee">Ik stuur geen bewijs mee, want ik heb dit resultaat recent behaald bij ROC Midden Nederland.</label>
                </div>
            </div>
            <div id="fileContainer"></div>
            <button type="submit" name="submit" class="btn btn-primary">Verstuur</button>
        </form>
    </div>

    <script src="button.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>