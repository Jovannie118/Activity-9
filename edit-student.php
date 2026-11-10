<?php
require_once __DIR__ . '/functions.php';

$students = getStudents();
$studentId = trim($_GET['id'] ?? $_POST['id'] ?? '');
$student = getStudentById($students, $studentId);

if ($student === null) {
    setFlash('error', 'Student record not found.');
    redirect('students.php');
}

$errors = [];
$formData = $student;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach (array_keys($formData) as $field) {
        $formData[$field] = trim((string) ($_POST[$field] ?? ''));
    }

    $errors = validateStudentData($_POST, $students, $student['id']);

    if (empty($errors)) {
        $updatedStudent = normalizeStudentData($_POST);
        $updatedStudent['id'] = $student['id'];

        $index = getStudentIndexById($students, $student['id']);
        $students[$index] = $updatedStudent;
        saveStudents($students);

        setFlash('success', 'Student "' . formatFullName($updatedStudent) . '" was updated successfully.');

        redirect('student-details.php?id=' . urlencode($updatedStudent['id']));
    }
}

$studentId = $student['id'];
$formMode = 'edit';
$formAction = 'edit-student.php?id=' . urlencode($student['id']);
$submitLabel = 'Save Changes';
$cancelUrl = 'student-details.php?id=' . urlencode($student['id']);

$activePage = 'students';
$pageTitle = 'Edit Student';
$pageSubtitle = 'Update an existing student record';

include __DIR__ . '/includes/header.php';
?>

<div class="page-intro">
    <div>
        <a href="student-details.php?id=<?= e(urlencode($student['id'])) ?>" class="back-link">
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back to Student Details
        </a>
        <h2>Edit Record for <?= e(formatFullName($student)) ?></h2>
        <p>Update the information below, then save your changes.</p>
    </div>
    <div class="intro-student">
        <span class="avatar avatar-md" style="background-color: <?= e(getAvatarColor($student['id'])) ?>;"><?= e(getInitials($student)) ?></span>
        <div>
            <strong><?= e($student['id']) ?></strong>
            <span><?= e($student['course']) ?> &bull; <?= e($student['year_level']) ?></span>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/student-form.php'; ?>

<?php include __DIR__ . '/includes/footer.php'; ?>
