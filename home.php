<?php

/* if (file_exists("contacts.json")){
  $contacts = json_decode(file_get_contents("contacts.json"), true);

}else{
  $contacts = [];
} */
require "dataBase.php";
session_start();
if (!isset($_SESSION["user"])){
  header("Location: login.php");
  return;
}
//var_dump($_COOKIE);
$conexion = new Conexion();
$conn = $conexion->conectar();

if (isset($_GET["id"])){
  $id = $_GET["id"];
  $statement = $conn->prepare("SELECT * FROM contacts WHERE id = :id");
  $statement->execute([":id" => $id]);
  if ($statement->rowCount() == 0){
    http_response_code(404);
    echo("HTTP 404 NOT FOUND");
    return;
  } else{
    $contact = $statement->fetch(PDO::FETCH_ASSOC);
    $userID = $_SESSION["user"]["id"];
    if ($contact["user_id"] != $userID){
      http_response_code(403);
      echo("HTTP 404 UNAUTHORIZED");
      return;
    } else{
      $conn->prepare("DELETE FROM contacts WHERE id = :id")->execute([":id" => $id]);
      //$statement->bindValue(":id", $id);
      $_SESSION["flash"] = ["message" => "Contact {$contac["name"]} Deleted."];

      header("Location: home.php");
      return;
    }
  }
}

$id = $_SESSION["user"]["id"];
$statement = $conn->prepare("SELECT * FROM contacts WHERE user_id = :id");
$statement->execute([":id" => $id]);
$contacts = $statement->fetchAll();
/* var_dump($contacts);
die(); */

include("./include/header.php");

?>

<div class="container pt-4 p-3">
  <div class="row">
    
    <?php if ($statement->rowCount() == 0): ?>
      <div class="col-md-4 mx-auto">
        <div class="card card-body text-center">
          <p>No contacts saved yet</p>
          <a href="./add.php">Add One!</a>
        </div>
      </div>
    <?php endif ?>
    <?php foreach ($contacts as $contact): ?>
      <div class="col-md-4 mb-3">
        <div class="card text-center">
          <div class="card-body">
            <h3 class="card-title text-capitalize"><?= $contact["name"] ?></h3>
            <p class="m-2"><?= $contact["phone_number"] ?></p>
            <a href="edit.php?id=<?= $contact["id"] ?>" class="btn btn-secondary mb-2">Edit Contact</a>
            <a href="home.php?id=<?= $contact["id"] ?>" class="btn btn-danger mb-2">Delete Contact</a>
          </div>
        </div>
      </div>
    <?php endforeach ?>

  </div>
</div>

<?php include("./include/footer.php"); ?>
