CREATE DATABASE IF NOT EXISTS campus_events_hub
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE campus_events_hub;

DROP TABLE IF EXISTS contact_messages;
DROP TABLE IF EXISTS registrations;
DROP TABLE IF EXISTS events;

CREATE TABLE events (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    category VARCHAR(80) NOT NULL,
    event_date DATE NOT NULL,
    event_time TIME NOT NULL,
    location VARCHAR(150) NOT NULL,
    short_description VARCHAR(255) NOT NULL,
    full_description TEXT NOT NULL,
    image VARCHAR(150) NOT NULL,
    available_seats INT UNSIGNED NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE registrations (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(120) NOT NULL,
    student_id VARCHAR(30) NOT NULL,
    email VARCHAR(150) NOT NULL,
    event_id INT UNSIGNED NOT NULL,
    registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_registrations_event
        FOREIGN KEY (event_id) REFERENCES events(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT unique_student_event UNIQUE (student_id, event_id)
) ENGINE=InnoDB;

CREATE TABLE contact_messages (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(120) NOT NULL,
    email VARCHAR(150) NOT NULL,
    subject VARCHAR(180) NOT NULL,
    message TEXT NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;


INSERT INTO events
(title, category, event_date, event_time, location, short_description, full_description, image, available_seats)
VALUES
('Saudi Web Development Workshop', 'Workshop', '2027-02-15', '10:00:00', 'Computer Lab 2, Riyadh Campus',
 'Learn how to create responsive websites using HTML, CSS, PHP, and practical examples relevant to Saudi university students.',
 'This practical workshop introduces students to semantic HTML, responsive CSS layouts, and basic PHP programming. Participants will build a small website for a Saudi student activity and learn how front-end pages connect with server-side processing. The workshop is suitable for beginners and supports the development of digital skills needed in the Saudi technology sector.',
 'web-workshop.jpg', 40),

('Cybersecurity Awareness Seminar', 'Seminar', '2027-03-02', '12:30:00', 'Main Auditorium, Riyadh Campus',
 'Learn practical methods for protecting university accounts, personal information, mobile devices, and online identities.',
 'This seminar focuses on cybersecurity risks commonly faced by university students in Saudi Arabia, including phishing messages, fraudulent links, weak passwords, social engineering, and unsafe public Wi-Fi. Students will learn how to recognize suspicious communications, use multi-factor authentication, secure government and university accounts, and report cybersecurity incidents responsibly.',
 'cybersecurity.jpg', 120),

('Vision 2030 Business Innovation Competition', 'Competition', '2027-03-20', '09:00:00', 'College of Business Hall, Riyadh',
 'Present an innovative business idea that supports Saudi Vision 2030 and compete for mentoring, recognition, and prizes.',
 'Student teams will develop and present innovative solutions related to tourism, sustainability, digital services, education, healthcare, or community development in Saudi Arabia. Each team will deliver a short presentation to a judging panel. Ideas will be evaluated based on originality, feasibility, market value, social impact, and alignment with Saudi Vision 2030 objectives.',
 'business-competition.jpg', 80),

('Artificial Intelligence for Saudi Students Workshop', 'Workshop', '2027-04-08', '11:00:00', 'Innovation and Entrepreneurship Lab, Riyadh',
 'Explore basic artificial intelligence concepts and their applications in education, business, healthcare, and government services.',
 'This beginner-friendly workshop introduces machine learning, natural language processing, data analysis, and responsible artificial intelligence. Students will explore examples of AI applications used in Saudi education, smart cities, healthcare, and digital government services. The session also discusses ethical use, data privacy, and the importance of developing local digital skills.',
 'artificial-intelligence.jpg', 45),

('Historical Diriyah Cultural Trip', 'Trip', '2027-04-24', '07:30:00', 'Departure from Riyadh Campus Main Gate',
 'Join an educational visit to Diriyah and explore Saudi history, cultural identity, and traditional Najdi architecture.',
 'This guided trip gives students an opportunity to visit the historic At-Turaif District in Diriyah and learn about the establishment of the First Saudi State. Participants will explore traditional Najdi architecture, heritage sites, and cultural exhibitions. University transportation is included, and students must arrive at the main campus gate at least fifteen minutes before departure.',
 'cultural-trip.jpg', 50),

('Saudi Graduate Career Readiness Seminar', 'Seminar', '2027-05-10', '13:00:00', 'Career Development Center, Riyadh Campus',
 'Improve your CV, interview skills, professional communication, networking, and understanding of the Saudi employment market.',
 'Career specialists will provide practical guidance on preparing professional Arabic and English CVs, presenting technical and personal skills, using LinkedIn effectively, and preparing for interviews with Saudi employers. The seminar will also discuss workplace expectations, internship opportunities, Saudization initiatives, and career paths in growing sectors connected to Saudi Vision 2030.',
 'career-seminar.jpg', 100);