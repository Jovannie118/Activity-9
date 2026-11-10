<?php
require_once __DIR__ . '/functions.php';

$students = getStudents();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = trim($_POST['id'] ?? '');
    $index = getStudentIndexById($students, $id);

    if ($index === -1) {
        setFlash('error', 'Student record not found or it has already been deleted.');
        redirect('students.php');
    }

    $student = $students[$index];
    array_splice($students, $index, 1);
    saveStudents($students);

    setFlash('success', 'Student "' . formatFullName($student) . '" was deleted successfully.');

    redirect('students.php');
}

$studentId = trim($_GET['id'] ?? '');
$student = getStudentById($students, $studentId);

if ($student === null) {
    setFlash('error', 'Student record not found.');
    redirect('students.php');
}

$fullName = formatFullName($student);

$activePage = 'students';
$pageTitle = 'Delete Student';
$pageSubtitle = 'Confirm record deletion';

include __DIR__ . '/includes/header.php';
?>

<div class="confirm-wrap">
    <div class="confirm-card">
        <div class="confirm-icon">
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                <line x1="12" y1="9" x2="12" y2="13"></line>
                <line x1="12" y1="17" x2="12.01" y2="17"></line>
            </svg>
        </div>

        <h2>Delete this student record?</h2>
        <p class="confirm-text">You are about to permanently remove this student from the current session. This action cannot be undone.</p>

        <div class="confirm-student">
            <span class="avatar avatar-lg" style="background-color: <?= e(getAvatarColor($student['id'])) ?>;"><?= e(getInitials($student)) ?></span>
            <div>
                <strong><?= e($fullName) ?></strong>
                <span><?= e($student['id']) ?> &bull; <?= e($student['course']) ?> &bull; <?= e($student['year_level']) ?></span>
                <span><?= e($student['email']) ?></span>
            </div>
        </div>

        <div class="alert alert-danger confirm-alert" role="alert">
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
            <div>
                <strong>Warning</strong>
                <p>The record will be removed from the student directory immediately.</p>
            </div>
        </div>

        <form method="post" action="delete-student.php" class="confirm-actions">
            <input type="hidden" name="id" value="<?= e($student['id']) ?>">
            <a href="student-details.php?id=<?= e(urlencode($student['id'])) ?>" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-danger">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path>
                    <path d="M10 11v6"></path>
                    <path d="M14 11v6"></path>
                    <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"></path>
                </svg>
                <span>Yes, Delete Student</span>
            </button>
        </form>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
