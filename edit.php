<?php

require "dataBase.php";
if (isset($_GET["id"])){
  $id = $_GET["id"];
  $conexion = new Conexion();
  $conn = $conexion->conectar();
  $statement = $conn->prepare("SELECT * FROM contacts WHERE id = :id LIMIT 1");
  $statement->execute([":id" => $id]);
  if ($statement->rowCount() == 0){
    http_response_code(404);
    echo("HTTP 404 NOT FOUND");
    return;
  }
  $contact = $statement->fetch(PDO::FETCH_ASSOC);
}

$error = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"]) || empty($_POST["phone_number"]) || empty($_POST["id"])){
    $error = "Please Fill all the fields.";
  } else if (strlen($_POST["phone_number"]) < 9) {
    $error = "Phone number must be least 9 characters.";
  } else {
    $name = $_POST["name"];
    $phoneNumber = $_POST["phone_number"];
    $id = $_POST["id"];
    
    $conexion = new Conexion();
    $conn = $conexion->conectar();
    $statement = $conn->prepare("UPDATE contacts SET name = :name, phone_number = :phone WHERE id = :id");
    $statement->execute([
      ":name" => $name,
      ":phone" => $phoneNumber,
      ":id" => $id
    ]);
    header("Location: home.php");
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
          <form method="POST" action="./edit.php">
            <input type="hidden" name="id" value="<?= $contact["id"] ?>">
            <div class="mb-3 row">
              <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>

              <div class="col-md-6">
                <input value="<?= $contact["name"] ?>" id="name" type="text" class="form-control" name="name" autocomplete="name" autofocus>
              </div>
            </div>

            <div class="mb-3 row">
              <label for="phone_number" class="col-md-4 col-form-label text-md-end">Phone Number</label>

              <div class="col-md-6">
                <input value="<?= $contact["phone_number"] ?>" id="phone_number" type="tel" class="form-control" name="phone_number" autocomplete="phone_number" autofocus>
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
