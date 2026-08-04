<?php
require_once 'includes/functions.php';
$pageTitle = 'About';
require 'includes/header.php';

$teamMembers = [
    ['name' => 'Anas Ghannam Alanazi', 'id' => 'S230030777', 'role' => 'Project Coordinator'],
    ['name' => 'Esam Aleidan', 'id' => 'S230033651', 'role' => 'Front-End Developer'],
    ['name' => 'Mohammad salah aldeen abu eshy', 'id' => 'S230040911', 'role' => 'PHP & Database Developer'],
    ['name' => 'Faisal Majed Alalawi', 'id' => 'S230026151', 'role' => 'Testing & Documentation']
];
?>
<section class="page-banner">
    <div class="container">
        <span class="eyebrow">Who We Are</span>
        <h1>About SEU Activities Club</h1>
        <p>A student-focused club that supports learning, participation, and campus connection.</p>
    </div>
</section>

<section class="section container about-layout">
    <article class="content-card">
        <span class="eyebrow">Our Mission</span>
        <h2>Creating useful and inclusive campus experiences</h2>
        <p>SEU Activities Club organizes educational and social events that complement academic learning. The club aims to help students strengthen practical skills, develop confidence, meet other students, and participate more actively in university life.</p>
    </article>

    <article class="content-card accent-card">
        <h2>Club Objectives</h2>
        <ul class="check-list dark-list">
            <li>Provide practical workshops and informative seminars.</li>
            <li>Encourage creativity through competitions and challenges.</li>
            <li>Support communication and teamwork among students.</li>
            <li>Promote cultural awareness and responsible participation.</li>
        </ul>
    </article>
</section>

<section class="section section-soft">
    <div class="container">
        <div class="section-heading centered">
            <div>
                <span class="eyebrow">Student Benefits</span>
                <h2>Why campus involvement matters</h2>
            </div>
        </div>
        <div class="benefit-grid">
            <article class="benefit-card"><span>01</span>
                <h3>Confidence</h3>
                <p>Present ideas, communicate with others, and take part in new activities.</p>
            </article>
            <article class="benefit-card"><span>02</span>
                <h3>Experience</h3>
                <p>Apply academic knowledge in practical and collaborative situations.</p>
            </article>
            <article class="benefit-card"><span>03</span>
                <h3>Community</h3>
                <p>Develop positive relationships and a stronger sense of belonging.</p>
            </article>
        </div>
    </div>
</section>

<section class="section container">
    <div class="section-heading centered">
        <div>
            <span class="eyebrow">Project Team</span>
            <h2>Meet the students behind the website</h2>
        </div>
    </div>
    <div class="team-grid">
        <?php foreach ($teamMembers as $index => $member): ?>
            <article class="team-card">
                <div class="avatar" aria-hidden="true"><?= e(substr($member['name'], 0, 1)) ?></div>
                <h3><?= e($member['name']) ?></h3>
                <p class="member-role"><?= e($member['role']) ?></p>
                <p class="member-id"><?= e($member['id']) ?></p>
            </article>
        <?php endforeach; ?>
    </div>
</section>
<?php require 'includes/footer.php'; ?>