<?php
  require "../vendor/autoload.php";
  $title = "Créer un évènement";

  use Calendar\Validator;
  use Calendar\Event;

  $event = new Event();
  $validate = (new Validator())->validates($_POST);
  $errors = [];
  if(empty($validate)){
    $event->create($_POST);
  }else{
    $errors = $validate;
  }
  
  
  require "../views/header.php";
?>
  <section class="section_event">
    <h2>Ajouter un Évènement</h2>

    <form action="" method="post">
      <div class="form_date_start">
        <input type="date" name="start_date" value="">
        <?php if(isset($errors["start_date"])): ?>
          <small><?= $errors["start_date"] ?></small>
        <?php endif ?>
      </div>
      <div class="form_time">
        <div>
          <input type="time" name="start_time" value=""><br>
          <?php if(isset($errors["start_time"])): ?>
            <small><?= $errors["start_time"] ?></small>
          <?php endif ?>
        </div>
        <input type="time" name="end_time" value="">
      </div>
      <div class="form_date_title">
        <input type="text" name="title" placeholder="Titre de l'évènement">
        <?php if(isset($errors["title"])): ?>
          <small><?= $errors["title"] ?></small>
        <?php endif ?>
      </div>
      <div class="form_date_description">
        <textarea name="description" placeholder="Description de l'évènement"></textarea>
      </div>
      <button type="submit">Ajouter</button>
    </form>
  </section>

<?php require "../views/footer.php"; ?>