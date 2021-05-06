<?php
require "connect.php";
require "helpers.php";

$errors = [];
if($_SERVER["REQUEST_METHOD"] === "POST"){
    if(validPOST("lieu") && validPOST("date") && validPOST("groupe") && validPOST("note")){
        $sql = "INSERT INTO concerts (lieu, date, groupe, note) VALUES (:lieu, :date, :groupe, :note)";
        $stmt = $db->prepare($sql);
        $res = $stmt->execute([
            "lieu" => htmlspecialchars($_POST["lieu"]),
            "date" => $_POST["date"],
            "groupe" => htmlspecialchars($_POST["groupe"]),
            "note" => htmlspecialchars($_POST["note"])
        ]);
        if($res === true){
            redirectTo("index.php");
        }else{
            $errors[] = "Erreur lors de la sauvegarde en base de données. Veuillez réessayer ultérieurement.";
        }
    }else{
        $errors[] = "Veuillez remplir tous les champs.";
    }
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un concert</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
</head>
<body>
    <div class="container d-flex flex-column align-items-center">
        <h1>Nouveau Concert</h1>
        <?php foreach($errors as $error){ ?>
            <div class="alert alert-warning">
                <?= $error ?>
            </div>
        <?php } ?>
        <div class="card p-4 w-50">
            <form method="POST">
                <div class="d-flex justify-content-between">
                    <div class="form-group w-50">
                        <label for="input-lieu">Lieu</label><br/>
                        <select id="input-lieu" name="lieu">
                            <option value="">Choisir un lieu</option>
                            <option>Toulon</option>
                            <option>La Valette du Var</option>
                            <option>La Garde</option>
                            <option>Le Pradet</option>
                        </select>
                    </div>
                    <div class="form-group w-50">
                        <label for="input-groupe">Groupe</label><br/>
                        <select id="input-groupe" name="groupe">
                            <option>Groupe 1</option>
                            <option>Groupe 2</option>
                            <option>Groupe 3</option>
                            <option>Groupe 4</option>
                        </select>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <div class="form-group w-50">
                        <label for="input-date">Date</label><br/>
                        <input type="date" id="input-date" name="date"/>
                    </div>
                    <div class="form-group w-50">
                        <label for="input-note">Note</label><br/>
                        <select id="input-note" name="note">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="mt-3 btn btn-primary">Valider</button>
            </form>
        </div>
    </div>
</body>
</html>