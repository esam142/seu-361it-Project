<?php
require_once 'includes/database.php';
require_once 'includes/functions.php';

$pageTitle = 'Home';
$events = getNextThreeEvents($conn);
require 'includes/header.php';
?>
<section class="hero">
    <div class="container hero-content">
        <div class="hero-copy">
            <span class="eyebrow">Discover. Participate. Connect.</span>
            <h1>Make your campus experience more meaningful.</h1>
            <p>Explore workshops, seminars, competitions, and trips organized for SEU students.</p>
            <div class="button-row">
                <a class="button button-primary" href="events.php">Explore Events</a>
                <a class="button button-secondary" href="about.php">Meet the Club</a>
            </div>
        </div>
        <div class="hero-panel">
            <span class="hero-icon" aria-hidden="true">★</span>
            <h2>Learn beyond the classroom</h2>
            <p>Build useful skills, meet other students, and create memorable university experiences.</p>
            <ul class="check-list">
                <li>Practical learning activities</li>
                <li>Student-friendly registration</li>
                <li>Varied events throughout the semester</li>
            </ul>
        </div>
    </div>
</section>

<section class="section container">
    <div class="section-heading">
        <div>
            <span class="eyebrow">Coming Soon</span>
            <h2>Next three events</h2>
        </div>
        <a class="text-link" href="events.php">View all events →</a>
    </div>

    <?php if ($events): ?>
        <div class="card-grid">
            <?php foreach ($events as $event): ?>
                <article class="event-card">
                    <img src="images/<?= e($event['image']) ?>" alt="<?= e($event['title']) ?>">
                    <div class="card-body">
                        <span class="badge"><?= e($event['category']) ?></span>
                        <h3><?= e($event['title']) ?></h3>
                        <p class="event-meta"><strong>Date:</strong> <?= e(formatDate($event['event_date'])) ?></p>
                        <p class="event-meta"><strong>Location:</strong> <?= e($event['location']) ?></p>
                        <p><?= e($event['short_description']) ?></p>
                        <a class="button button-small" href="event.php?id=<?= (int) $event['id'] ?>">View Details</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty-state">No upcoming events are available at the moment.</div>
    <?php endif; ?>
</section>

<section class="section section-soft">
    <div class="container">
        <div class="section-heading centered">
            <div>
                <span class="eyebrow">Why Join?</span>
                <h2>More than just attending an event</h2>
            </div>
        </div>
        <div class="benefit-grid">
            <article class="benefit-card">
                <span>01</span>
                <h3>Develop Skills</h3>
                <p>Gain practical knowledge through workshops, seminars, and competitions.</p>
            </article>
            <article class="benefit-card">
                <span>02</span>
                <h3>Build Connections</h3>
                <p>Meet students with similar interests and expand your university network.</p>
            </article>
            <article class="benefit-card">
                <span>03</span>
                <h3>Create Memories</h3>
                <p>Take part in enjoyable activities that make campus life more rewarding.</p>
            </article>
        </div>
    </div>
</section>
<?php require 'includes/footer.php'; ?>
