<?php
  use Calendar\Event;
  require "../vendor/autoload.php";
  $event = new Event();
  $event->find($_GET["id"]);

  require "../views/header.php";
?>
  
<?php require "../views/footer.php"; ?>