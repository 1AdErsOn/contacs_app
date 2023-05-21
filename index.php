<?php

$contacts = [
  ["name" => "Pepe", "phone_number" => "2132139"],
  ["name" => "Antonio", "phone_number" => "982392"],
  ["name" => "Nate", "phone_number" => "329847"],
  ["name" => "Rodrigo", "phone_number" => "4353234"],
  ["name" => "Marcos", "phone_number" => "12312432"],
];

include("./include/header.php");

?>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand font-weight-bold" href="#">
        <img class="mr-2" src="./static/img/logo.png" />
        ContactsApp
      </a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./add.php">Add Contact</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <main>
    <div class="container pt-4 p-3">
      <div class="row">
        
        <?php foreach ($contacts as $contact): ?>
          <div class="col-md-4 mb-3">
            <div class="card text-center">
              <div class="card-body">
                <h3 class="card-title text-capitalize"><?= $contact["name"] ?></h3>
                <p class="m-2"><?= $contact["phone_number"] ?></p>
                <a href="#" class="btn btn-secondary mb-2">Edit Contact</a>
                <a href="#" class="btn btn-danger mb-2">Delete Contact</a>
              </div>
            </div>
          </div>
        <?php endforeach ?>

      </div>
    </div>
  </main>

<?php include("./include/footer.php"); ?>
