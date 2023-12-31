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
  $eventByDate = $event->getAllEventsByDate($start, $end);

  require "../views/header.php";
?>
  <section>
    <h2 class="section_title"><?= $initialDate->toString() ?></h2>
    <div class="section_links">
      <a href="?<?= $initialDate->urlPreviousMonth() ?>">&lt;</a>
      <a href="?<?= $initialDate->urlNextMonth() ?>">&gt;</a>
    </div>
  </section>

  <table class="table__calendar">
    <?php for($semaine = 0; $semaine < $initialDate->getWeeks(); $semaine++): ?>
      <tr class="table__week table__<?= $initialDate->getWeeks() ?>weeks">
        <?php foreach($initialDate->days as $k => $day):
              $addDays = (clone $start)->modify("+" . $k + ($semaine * 7) . " days");
              $everyEvent = $eventByDate[$addDays->format("Y-m-d")] ?? [];
        ?>
          <td>
            <?php if($semaine === 0): ?>
              <div class="calendar__day"><?= $day ?></div>
            <?php endif ?>
            <div class="calendar_number_day <?= $initialDate->isNotSameDate($addDays) ? "calendar_not_same_date" : '' ?>"><?= $addDays->format("d"); ?></div>
            <div class="calendar__events">
              <?php foreach($everyEvent as $e): ?>
                <p><span><?= date("H:i", $e["start"]) ?></span> - <a href="./edit.php?id=<?= $e["id"] ?>"><?= $e["title"] ?></a></p>
              <?php endforeach ?>
            </div>
          </td>
        <?php endforeach ?>
      </tr>
    <?php endfor; ?>
  </table>

  <button class="calendar_button">
    <a href="./addevent.php">+</a>
  </button>
<?php require "../views/footer.php"; ?>