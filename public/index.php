<?php
  use Calendar\Month;
  use Calendar\Event;

  require "../vendor/autoload.php";
  
  try {
    $initialDate = new Month($_GET["month"] ?? null, $_GET["year"] ?? null);
  } catch (\Exception $e) {
    echo $e->getMessage();
  }
  $weeks = $initialDate->getWeeks();
  $start = $initialDate->getStartDay();
  $start = $start->format("N") === "1" ? $start : $initialDate->getStartDay()->modify("last monday");
  $end = (clone $start)->modify("+" . (6 + 7 * ($weeks - 1)) . " days");
  
  $event = new Event();
  $event->getAllEvents($start, $end);
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
        <a href="?<?= $initialDate->urlPreviousMonth() ?>">&lt;</a>
        <a href="?<?= $initialDate->urlNextMonth() ?>">&gt;</a>
      </div>
    </header>

  <table class="table__calendar">
    <?php for($semaine = 0; $semaine < $initialDate->getWeeks(); $semaine++): ?>
      <tr class="table__week table__<?= $initialDate->getWeeks() ?>weeks">
        <?php foreach($initialDate->days as $k => $day):
              $addDays = (clone $start)->modify("+" . $k + ($semaine * 7) . " days");
        ?>
          <td>
            <?php if($semaine === 0): ?>
              <div class="calendar__day"><?= $day ?></div>
            <?php endif ?>
            <div class="calendar_number_day <?= $initialDate->isNotSameDate($addDays) ? "calendar_not_same_date" : '' ?>"><?= $addDays->format("d"); ?></div>
          </td>
        <?php endforeach ?>
      </tr>
    <?php endfor; ?>
  </table>
</body>
</html>