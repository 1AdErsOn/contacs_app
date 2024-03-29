<?php

session_start();
if (!isset($_SESSION["user"])){
  header("Location: login.php");
  return;
}

$error = null;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  require "dataBase.php";
  /* $contact = [
    "name" => $_POST["name"],
    "phone_number" => $_POST["phone_number"]
  ]; */
  if (empty($_POST["name"]) || empty($_POST["phone_number"])){
    $error = "Please Fill all the fields.";
  } else if (strlen($_POST["phone_number"]) < 9) {
    $error = "Phone number must be least 9 characters.";
  } else {
    $name = $_POST["name"];
    $phoneNumber = $_POST["phone_number"];
    $id = $_SESSION["user"]["id"];
    /* if (file_exists("contacts.json")){
      $contacts = json_decode(file_get_contents("contacts.json"), true);
    
    }else{
      $contacts = [];
    }
    $contacts[] = $contact;
    file_put_contents("contacts.json", json_encode($contacts)); */
    
    $conexion = new Conexion();
    $conn = $conexion->conectar();
    //$resp = $conn->query("INSERT INTO contacts (name, phone_number) VALUES ('".$contact["name"]."','".$contact["phone_number"]."')");
    $statement = $conn->prepare("INSERT INTO contacts (name, user_id, phone_number) VALUES (:name, :id, :phone)");
    $resp = $statement->execute([
      ":name" => $name,
      ":id" => $id,
      ":phone" => $phoneNumber
    ]);

    $_SESSION["flash"] = ["message" => "Contact {$name} Added."];

    header("Location: home.php");
    return;
  }
}

include("./include/header.php"); 
?>

<div class="container pt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Add New Contact</div>
        <div class="card-body">
          <?php if ($error): ?>
            <p class="text-danger">
              <?= $error ?>
            </p>
          <?php endif ?>
          <form method="POST" action="./add.php">
            <div class="mb-3 row">
              <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>

              <div class="col-md-6">
                <input id="name" type="text" class="form-control" name="name" autocomplete="name" autofocus>
              </div>
            </div>

            <div class="mb-3 row">
              <label for="phone_number" class="col-md-4 col-form-label text-md-end">Phone Number</label>

              <div class="col-md-6">
                <input id="phone_number" type="tel" class="form-control" name="phone_number" autocomplete="phone_number" autofocus>
              </div>
            </div>

            <div class="mb-3 row">
              <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include("./include/footer.php"); ?>
