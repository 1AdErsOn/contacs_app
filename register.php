<?php

session_start();
if (isset($_SESSION["user"])){
  header("Location: home.php");
  return;
}

$error = null;
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  require "dataBase.php";

  if (empty($_POST["name"]) || empty($_POST["email"]) || empty($_POST["password"])){
    $error = "Please fill all the fields.";
  } else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
    $error = "Please enter a valid email.";
  } else if (strlen($_POST["password"]) < 8) {
    $error = "Password can not be less to 8 characters.";
  } else {
    //get values
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    //encript password
    $hasPassword = password_hash($password, PASSWORD_BCRYPT);//$hasPassword = md5($password);
    //conection to database
    $conexion = new Conexion();
    $conn = $conexion->conectar();

    $statement = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $statement->execute([":email" => $email]);
    if ($statement->rowCount() == 0){
      $conn
        ->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :pass)")
        ->execute([
          ":name" => $name,
          ":email" => $email,
          ":pass" => $hasPassword
        ]);
      $statement = $conn->prepare("SELECT * FROM users WHERE email = :email");
      $statement->execute([":email" => $email]);
      $user = $statement->fetch(PDO::FETCH_ASSOC);
      session_start();
      unset($user["password"]);
      $_SESSION["user"] = $user;
      header("location: home.php");
      return;
    } else{
      $error = "Email already registered, please use another email.";
    }

  }
}

include("./include/header.php"); 
?>

<div class="container pt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Register</div>
        <div class="card-body">
          <?php if ($error): ?>
            <p class="text-danger">
              <?= $error ?>
            </p>
          <?php endif ?>
          <form method="POST" action="./register.php">

            <div class="mb-3 row">
              <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>
              <div class="col-md-6">
                <input id="name" type="text" class="form-control" name="name" autocomplete="name" autofocus>
              </div>
            </div>

            <div class="mb-3 row">
              <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>
              <div class="col-md-6">
                <input id="email" type="email" class="form-control" name="email" autocomplete="email" autofocus>
              </div>
            </div>

            <div class="mb-3 row">
              <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>
              <div class="col-md-6">
                <input id="password" type="password" class="form-control" name="password" autocomplete="password" autofocus>
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
