<?php
require_once 'includes/database.php';
require_once 'includes/functions.php';

$pageTitle = 'Contact';
$errors = [];
$success = false;
$fullName = '';
$email = '';
$subject = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($fullName === '' || mb_strlen($fullName) < 3) {
        $errors[] = 'Full name must contain at least three characters.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Enter a valid email address.';
    }

    if (mb_strlen($subject) < 5) {
        $errors[] = 'Subject must contain at least five characters.';
    }

    if (mb_strlen($message) < 10) {
        $errors[] = 'Message must contain at least ten characters.';
    }

    if (!$errors) {
        $stmt = $conn->prepare(
            'INSERT INTO contact_messages (full_name, email, subject, message) VALUES (?, ?, ?, ?)'
        );

        if ($stmt) {
            $stmt->bind_param('ssss', $fullName, $email, $subject, $message);
            if ($stmt->execute()) {
                $success = true;
                $fullName = $email = $subject = $message = '';
            } else {
                $errors[] = 'Your message could not be saved. Please try again.';
            }
            $stmt->close();
        } else {
            $errors[] = 'The contact service is temporarily unavailable.';
        }
    }
}

require 'includes/header.php';
?>
<section class="page-banner">
    <div class="container">
        <span class="eyebrow">Get in Touch</span>
        <h1>Contact the Club</h1>
        <p>Send a question, suggestion, or comment to the SEU Activities Club team.</p>
    </div>
</section>

<section class="section container contact-layout">
    <aside class="contact-info">
        <span class="eyebrow">Contact Information</span>
        <h2>We welcome student feedback.</h2>
        <p>Use the form to ask about events, registration, club activities, or future suggestions.</p>
        <ul class="contact-list">
            <li><strong>Email</strong><span>activities@seu.example</span></li>
            <li><strong>Office Hours</strong><span>Sunday–Thursday, 9:00 AM–3:00 PM</span></li>
            <li><strong>Location</strong><span>Student Activities Office</span></li>
        </ul>
    </aside>

    <div>
        <?php if ($success): ?>
            <div class="message success-message" role="status">
                <h2>Message received</h2>
                <p>Thank you. Your message has been stored successfully.</p>
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

        <form class="form-card" method="post" action="contact.php" novalidate>
            <div class="form-group">
                <label for="full_name">Full Name *</label>
                <input type="text" id="full_name" name="full_name" value="<?= e($fullName) ?>" maxlength="120" required autocomplete="name">
            </div>
            <div class="form-group">
                <label for="email">Email Address *</label>
                <input type="email" id="email" name="email" value="<?= e($email) ?>" maxlength="150" required autocomplete="email">
            </div>
            <div class="form-group">
                <label for="subject">Subject *</label>
                <input type="text" id="subject" name="subject" value="<?= e($subject) ?>" maxlength="180" required>
            </div>
            <div class="form-group">
                <label for="message">Message *</label>
                <textarea id="message" name="message" rows="6" maxlength="2000" required><?= e($message) ?></textarea>
            </div>
            <button class="button button-primary button-full" type="submit">Send Message</button>
        </form>
    </div>
</section>
<?php require 'includes/footer.php'; ?>
