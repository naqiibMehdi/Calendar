<?php
  use Calendar\Month;
  require "../vendor/autoload.php";
  $initialDate = new Month();
  $lastMonday = $initialDate->getStartDay()->modify("last monday");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/app.css">
  <title>Calendrier</title>
</head>
<body>
    <header>
      <h1 class="header_title"><?= $initialDate->toString() ?></h1>
      <div class="header_links">
        <a href="">&lt;</a>
        <a href="">&gt;</a>
      </div>
    </header>

  <table class="table__calendar">
    <?php for($semaine = 0; $semaine < $initialDate->getWeeks(); $semaine++): ?>
      <tr class="table__week table__<?= $initialDate->getWeeks() ?>weeks">
        <?php foreach($initialDate->days as $k => $day): ?>
          <td>
            <?php if($semaine === 0): ?>
              <div class="calendar__day"><?= $day ?></div>
            <?php endif ?>
            <div class="calendar_number_day <?= $initialDate->isNotSameDate((clone $lastMonday)->modify("+" . $k + ($semaine * 7) . " day")) ? "calendar_not_same_date" : '' ?>"><?= (clone $lastMonday)->modify("+" . $k + ($semaine * 7) . " day")->format("d"); ?></div>
          </td>
        <?php endforeach ?>
      </tr>
    <?php endfor; ?>
  </table>
</body>
</html>