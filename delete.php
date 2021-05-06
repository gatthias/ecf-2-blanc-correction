<?php
require "connect.php";
require "helpers.php";

if(!validGET("id")){
    redirectTo("index.php");
}
$id = $_GET["id"];
$errors = [];

// Check & get db row
$stmt = $db->prepare("SELECT * FROM concerts WHERE id=?");

$concert = null;
if($stmt->execute([$id])){
    $concert = $stmt->fetch();
}else{
    $errors[] = "Le concert avec l'id $id n'a pu être trouvé";
}

// Protection CSRF
session_start();
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
$token = $_SESSION['token'];


if($_SERVER["REQUEST_METHOD"] === "POST"){
    if(isset($_POST["delete"])){
        // Check the CSRF token
        if(validPOST("token") && hash_equals($token, $_POST['token'])){
            $stmt = $db->prepare("DELETE FROM concerts WHERE id=?");
            if($stmt->execute([$id])){
                redirectTo("index.php");
            }else{
                $errors[] = "Une erreur est survenue lors de la suppression. Veuillez réessayer plus tard.";
            }
        }else{
            $errors[] = "Mauvais token de connexion. Veuillez réessayer.";
        }
    }else if(isset($_POST["cancel"])){
        redirectTo("index.php");
    }else{
        $errors[] = "Action non supportée.";
    }
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suppression</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
</head>
<body>
    <div class="container d-flex flex-column align-items-center">
        <h1>Suppression</h1>
        <?php foreach($errors as $error){ ?>
            <div class="alert alert-warning">
                <?= $error ?>
            </div>
        <?php } ?>
    
        <div class="card p-4 w-50">
            <p>
                Êtes-vous sûr de vouloir supprimer ce concert ?
            </p>
            <p>
                <em>Lieu: </em> <?= $concert["lieu"] ?><br/>
                <em>Date: </em> <?= afficheDateFR($concert["date"]) ?><br/>
                <em>Groupe: </em> <?= $concert["groupe"] ?><br/>
            </p>
            <div>
                <form method="POST" class="d-flex justify-content-around">
                    <?php // Gestion du token CSRF ?>
                    <input type="hidden" name="token" value="<?= $token ?>"/>
                    
                    <button type="submit" name="delete" class="btn btn-danger">Supprimer</button>
                    <button type="submit" name="cancel" class="btn btn-primary">Annuler</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>