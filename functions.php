<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/data.php';

function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function redirect($url)
{
    header('Location: ' . $url);
    exit;
}

function getStudents()
{
    global $initialStudents;

    if (!isset($_SESSION['students']) || !is_array($_SESSION['students'])) {
        $_SESSION['students'] = $initialStudents;
    }

    return $_SESSION['students'];
}

function saveStudents($students)
{
    $_SESSION['students'] = array_values($students);
}

function getCourses()
{
    return ['BSIT', 'BSCS', 'BSIS', 'BSED', 'BSN', 'BSEE'];
}

function getYearLevels()
{
    return ['1st Year', '2nd Year', '3rd Year', '4th Year'];
}

function getGenderOptions()
{
    return ['Male', 'Female', 'Other'];
}

function formatFullName($student)
{
    $first = trim($student['first_name'] ?? '');
    $last = trim($student['last_name'] ?? '');

    return ucwords(strtolower(trim($first . ' ' . $last)));
}

function getInitials($student)
{
    $first = trim($student['first_name'] ?? '');
    $last = trim($student['last_name'] ?? '');
    $initials = '';

    if ($first !== '') {
        $initials .= strtoupper(substr($first, 0, 1));
    }

    if ($last !== '') {
        $initials .= strtoupper(substr($last, 0, 1));
    }

    return $initials !== '' ? $initials : '?';
}

function getAvatarColor($seed)
{
    $palette = [
        '#2563eb',
        '#7c3aed',
        '#0891b2',
        '#059669',
        '#d97706',
        '#dc2626',
        '#be185d',
        '#4f46e5'
    ];

    $index = crc32(strtolower(trim($seed))) % count($palette);

    return $palette[$index];
}

function countStudents($students)
{
    return count($students);
}

function countByGender($students, $gender)
{
    $count = 0;

    foreach ($students as $student) {
        if (strcasecmp(trim($student['gender']), $gender) === 0) {
            $count++;
        }
    }

    return $count;
}

function averageAge($students)
{
    $total = count($students);

    if ($total === 0) {
        return 0;
    }

    $sum = 0;

    foreach ($students as $student) {
        $sum += (int) $student['age'];
    }

    return $sum / $total;
}

function countByCourse($students)
{
    $counts = [];

    foreach ($students as $student) {
        $course = strtoupper(trim($student['course']));

        if (!isset($counts[$course])) {
            $counts[$course] = 0;
        }

        $counts[$course]++;
    }

    arsort($counts);

    return $counts;
}

function percentage($part, $total)
{
    if ($total <= 0) {
        return 0;
    }

    return round(($part / $total) * 100, 1);
}

function generateStudentId($students)
{
    $highest = 0;

    foreach ($students as $student) {
        if (preg_match('/^STU-(\d+)$/', $student['id'], $matches)) {
            $number = (int) $matches[1];

            if ($number > $highest) {
                $highest = $number;
            }
        }
    }

    return 'STU-' . str_pad((string) ($highest + 1), 3, '0', STR_PAD_LEFT);
}

function getStudentById($students, $id)
{
    $id = trim($id);

    foreach ($students as $student) {
        if (strcasecmp($student['id'], $id) === 0) {
            return $student;
        }
    }

    return null;
}

function getStudentIndexById($students, $id)
{
    $id = trim($id);

    foreach ($students as $index => $student) {
        if (strcasecmp($student['id'], $id) === 0) {
            return $index;
        }
    }

    return -1;
}

function searchStudents($students, $term)
{
    $term = trim($term);

    if ($term === '') {
        return $students;
    }

    $needle = strtolower($term);
    $results = [];

    foreach ($students as $student) {
        $haystack = strtolower(implode(' ', [
            $student['id'],
            $student['first_name'],
            $student['last_name'],
            formatFullName($student),
            $student['course']
        ]));

        if (strpos($haystack, $needle) !== false) {
            $results[] = $student;
        }
    }

    return $results;
}

function getRecentStudents($students, $limit = 5)
{
    return array_slice(array_reverse($students), 0, $limit);
}

function formatContact($contact)
{
    $contact = trim($contact);

    if (strlen($contact) !== 11) {
        return $contact;
    }

    return substr($contact, 0, 4) . ' ' . substr($contact, 4, 3) . ' ' . substr($contact, 7, 4);
}

function highlightTerm($text, $term)
{
    $safeText = e($text);
    $term = trim($term);

    if ($term === '') {
        return $safeText;
    }

    $pattern = '/(' . preg_quote(e($term), '/') . ')/i';

    return preg_replace($pattern, '<mark class="highlight">$1</mark>', $safeText);
}

function normalizeStudentData($data)
{
    return [
        'id' => strtoupper(trim($data['id'] ?? '')),
        'first_name' => ucwords(strtolower(trim($data['first_name'] ?? ''))),
        'last_name' => ucwords(strtolower(trim($data['last_name'] ?? ''))),
        'age' => (int) ($data['age'] ?? 0),
        'gender' => ucfirst(strtolower(trim($data['gender'] ?? ''))),
        'course' => strtoupper(trim($data['course'] ?? '')),
        'year_level' => trim($data['year_level'] ?? ''),
        'email' => strtolower(trim($data['email'] ?? '')),
        'contact' => preg_replace('/[^0-9]/', '', trim($data['contact'] ?? '')),
        'address' => ucwords(strtolower(trim($data['address'] ?? '')))
    ];
}

function validateStudentData($data, $students, $excludeId = null)
{
    $errors = [];

    $firstName = trim($data['first_name'] ?? '');
    $lastName = trim($data['last_name'] ?? '');
    $age = trim((string) ($data['age'] ?? ''));
    $gender = trim($data['gender'] ?? '');
    $course = strtoupper(trim($data['course'] ?? ''));
    $yearLevel = trim($data['year_level'] ?? '');
    $email = strtolower(trim($data['email'] ?? ''));
    $contact = preg_replace('/[^0-9]/', '', trim($data['contact'] ?? ''));
    $address = trim($data['address'] ?? '');

    if ($firstName === '') {
        $errors['first_name'] = 'First name is required.';
    } elseif (strlen($firstName) < 2) {
        $errors['first_name'] = 'First name must be at least 2 characters.';
    } elseif (!preg_match("/^[a-zA-Z .'-]+$/", $firstName)) {
        $errors['first_name'] = 'First name contains invalid characters.';
    }

    if ($lastName === '') {
        $errors['last_name'] = 'Last name is required.';
    } elseif (strlen($lastName) < 2) {
        $errors['last_name'] = 'Last name must be at least 2 characters.';
    } elseif (!preg_match("/^[a-zA-Z .'-]+$/", $lastName)) {
        $errors['last_name'] = 'Last name contains invalid characters.';
    }

    if ($age === '') {
        $errors['age'] = 'Age is required.';
    } elseif (!ctype_digit($age)) {
        $errors['age'] = 'Age must be a whole number.';
    } elseif ((int) $age < 15 || (int) $age > 100) {
        $errors['age'] = 'Age must be between 15 and 100.';
    }

    if (!in_array($gender, getGenderOptions(), true)) {
        $errors['gender'] = 'Please select a valid gender.';
    }

    if ($course === '') {
        $errors['course'] = 'Course is required.';
    } elseif (!in_array($course, getCourses(), true)) {
        $errors['course'] = 'Please select a valid course.';
    }

    if (!in_array($yearLevel, getYearLevels(), true)) {
        $errors['year_level'] = 'Please select a valid year level.';
    }

    if ($email === '') {
        $errors['email'] = 'Email address is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email address.';
    } else {
        foreach ($students as $student) {
            if ($excludeId !== null && strcasecmp($student['id'], $excludeId) === 0) {
                continue;
            }

            if (strcasecmp($student['email'], $email) === 0) {
                $errors['email'] = 'This email address is already used by another student.';
                break;
            }
        }
    }

    if ($contact === '') {
        $errors['contact'] = 'Contact number is required.';
    } elseif (strlen($contact) !== 11) {
        $errors['contact'] = 'Contact number must contain exactly 11 digits.';
    } elseif (substr($contact, 0, 2) !== '09') {
        $errors['contact'] = 'Contact number must start with 09.';
    }

    if ($address === '') {
        $errors['address'] = 'Address is required.';
    } elseif (strlen($address) < 5) {
        $errors['address'] = 'Address must be at least 5 characters.';
    }

    return $errors;
}

function setFlash($type, $message)
{
    $_SESSION['flash'] = [
        'type' => $type,
        'message' => $message
    ];
}

function getFlash()
{
    if (!isset($_SESSION['flash'])) {
        return null;
    }

    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);

    return $flash;
}
