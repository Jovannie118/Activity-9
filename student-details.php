<?php
require_once __DIR__ . '/functions.php';

$students = getStudents();
$studentId = trim($_GET['id'] ?? '');
$student = getStudentById($students, $studentId);

if ($student === null) {
    setFlash('error', 'Student record not found.');
    redirect('students.php');
}

$fullName = formatFullName($student);

$activePage = 'students';
$pageTitle = 'Student Details';
$pageSubtitle = 'Complete student information';

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
    </div>
</div>

<section class="profile-card">
    <div class="profile-main">
        <span class="avatar avatar-xl" style="background-color: <?= e(getAvatarColor($student['id'])) ?>;"><?= e(getInitials($student)) ?></span>
        <div class="profile-info">
            <div class="profile-badges">
                <span class="badge course-<?= e(strtolower($student['course'])) ?>"><?= e($student['course']) ?></span>
                <span class="badge badge-<?= e(strtolower($student['gender'])) ?>"><?= e($student['gender']) ?></span>
            </div>
            <h2><?= e($fullName) ?></h2>
            <p><?= e($student['id']) ?> &bull; <?= e($student['year_level']) ?> &bull; <?= e($student['course']) ?></p>
        </div>
    </div>
    <div class="profile-actions">
        <a href="edit-student.php?id=<?= e(urlencode($student['id'])) ?>" class="btn btn-primary">
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M12 20h9"></path>
                <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
            </svg>
            <span>Edit Student</span>
        </a>
        <a href="delete-student.php?id=<?= e(urlencode($student['id'])) ?>" class="btn btn-danger-outline js-delete" data-student-id="<?= e($student['id']) ?>" data-student-name="<?= e($fullName) ?>">
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <polyline points="3 6 5 6 21 6"></polyline>
                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path>
                <path d="M10 11v6"></path>
                <path d="M14 11v6"></path>
                <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"></path>
            </svg>
            <span>Delete</span>
        </a>
    </div>
</section>

<div class="details-grid">
    <section class="card info-card">
        <div class="card-body">
            <div class="info-card-title">
                <span class="section-icon">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </span>
                <div>
                    <h3>Personal Information</h3>
                    <p>Identity and personal details.</p>
                </div>
            </div>

            <dl class="info-list">
                <div class="info-row">
                    <dt>Full Name</dt>
                    <dd><?= e($fullName) ?></dd>
                </div>
                <div class="info-row">
                    <dt>First Name</dt>
                    <dd><?= e($student['first_name']) ?></dd>
                </div>
                <div class="info-row">
                    <dt>Last Name</dt>
                    <dd><?= e($student['last_name']) ?></dd>
                </div>
                <div class="info-row">
                    <dt>Age</dt>
                    <dd><?= e($student['age']) ?> years old</dd>
                </div>
                <div class="info-row">
                    <dt>Gender</dt>
                    <dd><?= e($student['gender']) ?></dd>
                </div>
                <div class="info-row">
                    <dt>Address</dt>
                    <dd><?= e($student['address']) ?></dd>
                </div>
            </dl>
        </div>
    </section>

    <section class="card info-card">
        <div class="card-body">
            <div class="info-card-title">
                <span class="section-icon">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M22 10 12 5 2 10l10 5 10-5z"></path>
                        <path d="M6 12v5c0 1 2.5 3 6 3s6-2 6-3v-5"></path>
                        <line x1="22" y1="10" x2="22" y2="16"></line>
                    </svg>
                </span>
                <div>
                    <h3>Academic Information</h3>
                    <p>Enrollment and program details.</p>
                </div>
            </div>

            <dl class="info-list">
                <div class="info-row">
                    <dt>Student ID</dt>
                    <dd><span class="student-id"><?= e(strtoupper($student['id'])) ?></span></dd>
                </div>
                <div class="info-row">
                    <dt>Course</dt>
                    <dd><span class="badge course-<?= e(strtolower($student['course'])) ?>"><?= e($student['course']) ?></span></dd>
                </div>
                <div class="info-row">
                    <dt>Year Level</dt>
                    <dd><?= e($student['year_level']) ?></dd>
                </div>
                <div class="info-row">
                    <dt>Enrollment Status</dt>
                    <dd><span class="status-badge"><span class="status-dot"></span> Active</span></dd>
                </div>
            </dl>
        </div>
    </section>

    <section class="card info-card">
        <div class="card-body">
            <div class="info-card-title">
                <span class="section-icon">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M4 4h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                </span>
                <div>
                    <h3>Contact Information</h3>
                    <p>Direct ways to reach the student.</p>
                </div>
            </div>

            <dl class="info-list">
                <div class="info-row">
                    <dt>Email Address</dt>
                    <dd><a href="mailto:<?= e($student['email']) ?>" class="contact-link"><?= e($student['email']) ?></a></dd>
                </div>
                <div class="info-row">
                    <dt>Contact Number</dt>
                    <dd><a href="tel:<?= e($student['contact']) ?>" class="contact-link"><?= e(formatContact($student['contact'])) ?></a></dd>
                </div>
                <div class="info-row">
                    <dt>Complete Address</dt>
                    <dd><?= e($student['address']) ?></dd>
                </div>
            </dl>

            <div class="contact-actions">
                <a href="mailto:<?= e($student['email']) ?>" class="btn btn-secondary btn-sm">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M4 4h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                    <span>Send Email</span>
                </a>
                <a href="tel:<?= e($student['contact']) ?>" class="btn btn-secondary btn-sm">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"></path>
                    </svg>
                    <span>Call Student</span>
                </a>
            </div>
        </div>
    </section>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
