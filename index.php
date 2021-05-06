<?php
require "connect.php";
require "helpers.php";

$stmt = $db->query("SELECT * from concerts");
$concerts = $stmt->fetchAll();
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Concerts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="d-flex justify-content-between mt-3 mb-3">
            <h1>Liste des concerts</h1>
            <a class="btn btn-primary d-flex align-items-center" href="form.php">Ajouter in concert</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Lieu</th>
                    <th>Groupe</th>
                    <th>Note</th>
                    <th></th>
                </tr>
            </thead>
            <?php foreach($concerts as $concert){ ?>
                <tr>
                    <td><?= afficheDateFR($concert["date"]) ?></td>
                    <td><?= $concert["lieu"] ?></td>
                    <td><?= $concert["groupe"] ?></td>
                    <td><?= $concert["note"] ?></td>
                    <td>
                        <a href="delete.php?id=<?= $concert["id"] ?>">Supprimer</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>