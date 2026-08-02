<?php
require_once 'includes/database.php';
require_once 'includes/functions.php';

$pageTitle = 'Register';
$events = getUpcomingEvents($conn);
$errors = [];
$success = null;

$fullName = '';
$studentId = '';
$email = '';
$selectedEventId = filter_input(INPUT_GET, 'event_id', FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1]
]) ?: '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim($_POST['full_name'] ?? '');
    $studentId = trim($_POST['student_id'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $selectedEventId = filter_var($_POST['event_id'] ?? '', FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 1]
    ]);

    if ($fullName === '') {
        $errors[] = 'Full name is required.';
    } elseif (mb_strlen($fullName) < 3) {
        $errors[] = 'Full name must contain at least three characters.';
    } elseif (!preg_match("/^[\p{L} .'-]+$/u", $fullName)) {
        $errors[] = 'Full name may contain letters, spaces, apostrophes, periods, and hyphens only.';
    }

    if ($studentId === '') {
        $errors[] = 'Student ID is required.';
    } elseif (!isValidStudentId($studentId)) {
        $errors[] = 'Student ID must contain 5–20 letters or numbers only.';
    }

    if ($email === '') {
        $errors[] = 'Email address is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Enter a valid email address.';
    }

    $selectedEvent = $selectedEventId ? findEventById($conn, (int) $selectedEventId) : null;

    if (!$selectedEvent) {
        $errors[] = 'Please select a valid event.';
    } elseif (remainingSeats($conn, $selectedEvent) < 1) {
        $errors[] = 'The selected event is full.';
    } elseif (isDuplicateRegistration($conn, $studentId, (int) $selectedEventId)) {
        $errors[] = 'This student ID is already registered for the selected event.';
    }

    if (!$errors && $selectedEvent) {
        $stmt = $conn->prepare(
            'INSERT INTO registrations (full_name, student_id, email, event_id) VALUES (?, ?, ?, ?)'
        );

        if ($stmt) {
            $stmt->bind_param('sssi', $fullName, $studentId, $email, $selectedEventId);

            if ($stmt->execute()) {
                $registrationId = $stmt->insert_id;
                $success = [
                    'id' => $registrationId,
                    'name' => $fullName,
                    'event' => $selectedEvent['title'],
                    'date' => date('F j, Y, g:i A')
                ];
                $fullName = '';
                $studentId = '';
                $email = '';
                $selectedEventId = '';
            } else {
                $errors[] = $stmt->errno === 1062
                    ? 'This student ID is already registered for the selected event.'
                    : 'The registration could not be saved. Please try again.';
            }
            $stmt->close();
        } else {
            $errors[] = 'The registration service is temporarily unavailable.';
        }
    }
}

require 'includes/header.php';
?>
<section class="page-banner">
    <div class="container">
        <span class="eyebrow">Reserve Your Place</span>
        <h1>Event Registration</h1>
        <p>Complete the form below to register for an upcoming campus activity.</p>
    </div>
</section>

<section class="section container narrow-container">
    <?php if ($success): ?>
        <div class="message success-message">
            <h2>Registration confirmed</h2>
            <p>Your registration has been saved successfully.</p>
            <dl class="confirmation-list">
                <div><dt>Registration Number</dt><dd>#<?= (int) $success['id'] ?></dd></div>
                <div><dt>Student Name</dt><dd><?= e($success['name']) ?></dd></div>
                <div><dt>Selected Event</dt><dd><?= e($success['event']) ?></dd></div>
                <div><dt>Registered On</dt><dd><?= e($success['date']) ?></dd></div>
            </dl>
            <a class="button button-primary" href="events.php">Explore More Events</a>
        </div>
    <?php endif; ?>

    <?php if ($errors): ?>
        <div class="message error-message" role="alert">
            <h2>Please correct the following:</h2>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= e($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form class="form-card" method="post" action="register.php" novalidate>
        <div class="form-intro">
            <h2>Student details</h2>
            <p>Fields marked with * are required.</p>
        </div>

        <div class="form-group">
            <label for="full_name">Full Name *</label>
            <input type="text" id="full_name" name="full_name" value="<?= e($fullName) ?>" maxlength="120" required autocomplete="name">
        </div>

        <div class="form-group">
            <label for="student_id">Student ID *</label>
            <input type="text" id="student_id" name="student_id" value="<?= e($studentId) ?>" maxlength="20" required>
            <small>Use 5–20 letters or numbers.</small>
        </div>

        <div class="form-group">
            <label for="email">Email Address *</label>
            <input type="email" id="email" name="email" value="<?= e($email) ?>" maxlength="150" required autocomplete="email">
        </div>

        <div class="form-group">
            <label for="event_id">Selected Event *</label>
            <select id="event_id" name="event_id" required>
                <option value="">Choose an event</option>
                <?php foreach ($events as $event): ?>
                    <?php $seatsLeft = remainingSeats($conn, $event); ?>
                    <option value="<?= (int) $event['id'] ?>"
                        <?= (string) $selectedEventId === (string) $event['id'] ? 'selected' : '' ?>
                        <?= $seatsLeft < 1 ? 'disabled' : '' ?>>
                        <?= e($event['title']) ?> — <?= e(formatDate($event['event_date'])) ?>
                        <?= $seatsLeft < 1 ? ' (Full)' : '' ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button class="button button-primary button-full" type="submit">Submit Registration</button>
    </form>
</section>
<?php require 'includes/footer.php'; ?>
