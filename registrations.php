<?php
require_once 'includes/database.php';
require_once 'includes/functions.php';

$pageTitle = 'Registrations';
$sql = "SELECT r.id, r.full_name, r.student_id, r.email, r.registered_at,
               e.title AS event_title, e.event_date
        FROM registrations r
        INNER JOIN events e ON r.event_id = e.id
        ORDER BY r.registered_at DESC, r.id DESC";
$result = $conn->query($sql);
$registrations = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
require 'includes/header.php';
?>
<section class="page-banner">
    <div class="container">
        <span class="eyebrow">Registration Records</span>
        <h1>Student Registrations</h1>
        <p>This table displays the event registrations currently stored in the database.</p>
    </div>
</section>

<section class="section container">
    <?php if ($registrations): ?>
        <div class="table-summary">
            <h2>Registration List</h2>
            <span><?= count($registrations) ?> record<?= count($registrations) === 1 ? '' : 's' ?></span>
        </div>
        <div class="table-wrapper">
            <table>
                <caption class="visually-hidden">Students registered for campus events</caption>
                <thead>
                    <tr>
                        <th scope="col">Registration No.</th>
                        <th scope="col">Student Name</th>
                        <th scope="col">Student ID</th>
                        <th scope="col">Email</th>
                        <th scope="col">Event</th>
                        <th scope="col">Event Date</th>
                        <th scope="col">Registered On</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($registrations as $registration): ?>
                        <tr>
                            <td>#<?= (int) $registration['id'] ?></td>
                            <td><?= e($registration['full_name']) ?></td>
                            <td><?= e($registration['student_id']) ?></td>
                            <td><a href="mailto:<?= e($registration['email']) ?>"><?= e($registration['email']) ?></a></td>
                            <td><?= e($registration['event_title']) ?></td>
                            <td><?= e(formatDate($registration['event_date'])) ?></td>
                            <td><?= e(date('M j, Y g:i A', strtotime($registration['registered_at']))) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <h2>No registrations yet</h2>
            <p>Submitted student registrations will appear here.</p>
            <a class="button button-primary" href="register.php">Register Now</a>
        </div>
    <?php endif; ?>
</section>
<?php require 'includes/footer.php'; ?>