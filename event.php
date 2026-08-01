<?php
require_once 'includes/database.php';
require_once 'includes/functions.php';

$eventId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1]
]);
$event = $eventId ? findEventById($conn, $eventId) : null;
$pageTitle = $event ? $event['title'] : 'Event Not Found';
require 'includes/header.php';
?>
<section class="page-banner compact">
    <div class="container">
        <span class="eyebrow">Event Information</span>
        <h1><?= $event ? e($event['title']) : 'Event Not Found' ?></h1>
    </div>
</section>

<section class="section container">
    <?php if (!$event): ?>
        <div class="message error-message">
            <h2>We could not find this event.</h2>
            <p>The event link may be incorrect or the event may no longer be available.</p>
            <a class="button button-primary" href="events.php">Return to Events</a>
        </div>
    <?php else: ?>
        <?php
        $registered = countEventRegistrations($conn, (int) $event['id']);
        $seatsLeft = remainingSeats($conn, $event);
        ?>
        <article class="event-detail">
            <div class="event-detail-image">
                <img src="images/<?= e($event['image']) ?>" alt="<?= e($event['title']) ?>">
            </div>
            <div class="event-detail-content">
                <span class="badge"><?= e($event['category']) ?></span>
                <h2><?= e($event['title']) ?></h2>
                <div class="detail-facts">
                    <div><span>Date</span><strong><?= e(formatDate($event['event_date'])) ?></strong></div>
                    <div><span>Time</span><strong><?= e(formatTime($event['event_time'])) ?></strong></div>
                    <div><span>Location</span><strong><?= e($event['location']) ?></strong></div>
                    <div><span>Total Seats</span><strong><?= (int) $event['available_seats'] ?></strong></div>
                    <div><span>Registered</span><strong><?= $registered ?></strong></div>
                    <div><span>Remaining</span><strong><?= $seatsLeft ?></strong></div>
                </div>
                <h3>About this event</h3>
                <p><?= nl2br(e($event['full_description'])) ?></p>

                <?php if ($seatsLeft > 0): ?>
                    <a class="button button-primary" href="register.php?event_id=<?= (int) $event['id'] ?>">Register for This Event</a>
                <?php else: ?>
                    <span class="button button-disabled" aria-disabled="true">Event Full</span>
                <?php endif; ?>
            </div>
        </article>
    <?php endif; ?>
</section>
<?php require 'includes/footer.php'; ?>
