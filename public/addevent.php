<?php
  require "../vendor/autoload.php";
  $title = "Créer un évènement";
  dump($_POST);
  require "../views/header.php";
?>
  <section class="section_event">
    <h2>Ajouter un Évènement</h2>

    <form action="" method="post">
      <div class="form_date_start">
        <input type="date" name="start_date">
        <input type="time" name="start_time">
      </div>
      <div class="form_date_end">
        <input type="date" name="end_date">
        <input type="time" name="end_time">
      </div>
      <div class="form_date_title">
        <input type="text" name="title" placeholder="Titre de l'évènement">
      </div>
      <div class="form_date_description">
        <textarea name="description" placeholder="Description de l'évènement"></textarea>
      </div>
      <button type="submit">Ajouter</button>
    </form>
  </section>


<?php require "../views/footer.php"; ?>