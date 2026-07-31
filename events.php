<?php
require_once 'includes/database.php';
require_once 'includes/functions.php';

$pageTitle = 'Events';
$events = getUpcomingEvents($conn);
require 'includes/header.php';
?>
<section class="page-banner">
    <div class="container">
        <span class="eyebrow">SEU Activities Club</span>
        <h1>Upcoming Campus Events</h1>
        <p>Browse the available activities and choose the events that match your interests.</p>
    </div>
</section>

<section class="section container">
    <?php if ($events): ?>
        <div class="card-grid">
            <?php foreach ($events as $event): ?>
                <?php $seatsLeft = remainingSeats($conn, $event); ?>
                <article class="event-card">
                    <img src="images/<?= e($event['image']) ?>" alt="<?= e($event['title']) ?>">
                    <div class="card-body">
                        <div class="card-topline">
                            <span class="badge"><?= e($event['category']) ?></span>
                            <span class="seat-count <?= $seatsLeft === 0 ? 'full' : '' ?>">
                                <?= $seatsLeft === 0 ? 'Full' : e($seatsLeft) . ' seats left' ?>
                            </span>
                        </div>
                        <h2><?= e($event['title']) ?></h2>
                        <ul class="event-facts">
                            <li><strong>Date:</strong> <?= e(formatDate($event['event_date'])) ?></li>
                            <li><strong>Time:</strong> <?= e(formatTime($event['event_time'])) ?></li>
                            <li><strong>Location:</strong> <?= e($event['location']) ?></li>
                        </ul>
                        <p><?= e($event['short_description']) ?></p>
                        <a class="button button-small" href="event.php?id=<?= (int) $event['id'] ?>">View Details</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <h2>No events found</h2>
            <p>New activities will be announced soon.</p>
        </div>
    <?php endif; ?>
</section>
<?php require 'includes/footer.php'; ?>
