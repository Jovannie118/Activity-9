<?php
require_once __DIR__ . '/functions.php';

$students = getStudents();
$errors = [];
$formData = [
    'first_name' => '',
    'last_name' => '',
    'age' => '',
    'gender' => '',
    'course' => '',
    'year_level' => '',
    'email' => '',
    'contact' => '',
    'address' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach (array_keys($formData) as $field) {
        $formData[$field] = trim((string) ($_POST[$field] ?? ''));
    }

    $errors = validateStudentData($_POST, $students);

    if (empty($errors)) {
        $student = normalizeStudentData($_POST);
        $student['id'] = generateStudentId($students);

        $students[] = $student;
        saveStudents($students);

        setFlash('success', 'Student "' . formatFullName($student) . '" was added successfully with ID ' . $student['id'] . '.');

        redirect('students.php');
    }
}

$studentId = generateStudentId($students);
$formMode = 'add';
$formAction = 'add-student.php';
$submitLabel = 'Save Student';
$cancelUrl = 'students.php';

$activePage = 'add';
$pageTitle = 'Add Student';
$pageSubtitle = 'Create a new student record';

include __DIR__ . '/includes/header.php';
?>

<div class="page-intro">
    <div>
        <a href="students.php" class="back-link">
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back to Student Records
        </a>
        <h2>New Student Registration</h2>
        <p>Fill in the information below. The student ID will be generated automatically.</p>
    </div>
</div>

<?php include __DIR__ . '/includes/student-form.php'; ?>

<?php include __DIR__ . '/includes/footer.php'; ?>
