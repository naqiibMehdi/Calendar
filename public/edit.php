<?php
  use Calendar\Event;
  use Calendar\Validator;
  require "../vendor/autoload.php";

  $event = new Event();
  $validate = (new Validator)->validates($_POST);
  $datas = [];
  $errors = [];
  $id = (int)$_GET["id"] ?? null;
  
  if(!empty($event->find($id))){
    $datas = $event->find($id);

    if($_SERVER["REQUEST_METHOD"] === "POST"){
      if(empty($validate)){

      }else{
        $errors = $validate;
      }
      
    }
    
  }else{
    header("Location: 404.php", true, 301);
    exit();
  }

  require "../views/header.php";
?>

<section class="section_event">
    <h2>Modifier un Évènement</h2>

    <form action="" method="post">
      <div class="form_date_start">
        <input type="date" name="start_date" value="<?= $_POST["start_date"] ?? $datas["start_date"] ?>">
        <?php if(isset($errors["start_date"])): ?>
          <small><?= $errors["start_date"] ?></small>
        <?php endif ?>
      </div>
      <div class="form_time">
        <div>
          <input type="time" name="start_time" value="<?= $_POST["start_time"] ?? $datas["start_time"] ?>"><br>
          <?php if(isset($errors["start_time"]) || isset($errors["end_time"])): ?>
            <small><?= isset($errors["start_time"]) ? $errors["start_time"] : $errors["end_time"] ?></small>
          <?php endif ?>
        </div>
        <input type="time" name="end_time" value="<?= $_POST["end_time"] ?? $datas["end_time"]?>">
      </div>
      <div class="form_date_title">
        <input type="text" name="title" placeholder="Titre de l'évènement" value="<?= $_POST["title"] ?? $datas["title"]  ?>">
        <?php if(isset($errors["title"])): ?>
          <small><?= $errors["title"] ?></small>
        <?php endif ?>
      </div>
      <div class="form_date_description">
        <textarea name="description" placeholder="Description de l'évènement"><?= $_POST["description"] ?? $datas["description"]?></textarea>
      </div>
      <button type="submit">Modifier</button>
    </form>
  </section>
  
<?php require "../views/footer.php"; ?>