<?php
/** Escape text before displaying it in HTML. */
function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

/** Format a database date for visitors. */
function formatDate(string $date): string
{
    return date('F j, Y', strtotime($date));
}

/** Format a database time for visitors. */
function formatTime(string $time): string
{
    return date('g:i A', strtotime($time));
}

/** Return all upcoming events ordered by date and time. */
function getUpcomingEvents(mysqli $conn): array
{
    $sql = "SELECT * FROM events
            WHERE event_date >= CURDATE()
            ORDER BY event_date ASC, event_time ASC";

    $result = $conn->query($sql);
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}

/** Return the next three upcoming events. */
function getNextThreeEvents(mysqli $conn): array
{
    $sql = "SELECT * FROM events
            WHERE event_date >= CURDATE()
            ORDER BY event_date ASC, event_time ASC
            LIMIT 3";

    $result = $conn->query($sql);
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}

/** Find one event safely using a prepared statement. */
function findEventById(mysqli $conn, int $eventId): ?array
{
    $stmt = $conn->prepare('SELECT * FROM events WHERE id = ? LIMIT 1');
    if (!$stmt) {
        return null;
    }

    $stmt->bind_param('i', $eventId);
    $stmt->execute();
    $result = $stmt->get_result();
    $event = $result->fetch_assoc();
    $stmt->close();

    return $event ?: null;
}

/** Check a student ID format. */
function isValidStudentId(string $studentId): bool
{
    return (bool) preg_match('/^[A-Za-z0-9]{5,20}$/', $studentId);
}

/** Count registrations for one event. */
function countEventRegistrations(mysqli $conn, int $eventId): int
{
    $stmt = $conn->prepare('SELECT COUNT(*) AS total FROM registrations WHERE event_id = ?');
    if (!$stmt) {
        return 0;
    }

    $stmt->bind_param('i', $eventId);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    return (int) ($result['total'] ?? 0);
}

/** Calculate the remaining seats for an event. */
function remainingSeats(mysqli $conn, array $event): int
{
    $registered = countEventRegistrations($conn, (int) $event['id']);
    return max(0, (int) $event['available_seats'] - $registered);
}

/** Check whether the same student already registered for an event. */
function isDuplicateRegistration(mysqli $conn, string $studentId, int $eventId): bool
{
    $stmt = $conn->prepare(
        'SELECT id FROM registrations WHERE student_id = ? AND event_id = ? LIMIT 1'
    );

    if (!$stmt) {
        return false;
    }

    $stmt->bind_param('si', $studentId, $eventId);
    $stmt->execute();
    $result = $stmt->get_result();
    $exists = $result->num_rows > 0;
    $stmt->close();

    return $exists;
}
