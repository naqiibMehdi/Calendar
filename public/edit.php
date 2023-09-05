<?php
  use Calendar\Event;
  require "../vendor/autoload.php";
  $event = new Event();
  
  if($event->find($_GET["id"])){

  }else{
    header("Location: 404.php", true, 301);
    exit();
  }

  require "../views/header.php";
?>
  
<?php require "../views/footer.php"; ?>