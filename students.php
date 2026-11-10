<?php
require_once __DIR__ . '/functions.php';

$students = getStudents();
$searchTerm = trim($_GET['q'] ?? '');
$results = searchStudents($students, $searchTerm);
$totalStudents = countStudents($students);
$resultCount = count($results);
$focusSearch = isset($_GET['focus']);

$activePage = ($focusSearch || $searchTerm !== '') ? 'search' : 'students';
$pageTitle = 'Student Records';
$pageSubtitle = 'Browse, search, and manage student information';

include __DIR__ . '/includes/header.php';
?>

<div class="records-toolbar">
    <form method="get" action="students.php" class="search-form" role="search">
        <div class="search-input-wrap">
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            <input type="search" id="studentSearchInput" name="q" value="<?= e($searchTerm) ?>" placeholder="Search by student ID, first name, last name, or course..." <?= $focusSearch ? 'autofocus' : '' ?>>
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
        <?php if ($searchTerm !== ''): ?>
            <a href="students.php" class="btn btn-secondary">Clear</a>
        <?php endif; ?>
    </form>

    <a href="add-student.php" class="btn btn-primary toolbar-add">
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <line x1="12" y1="5" x2="12" y2="19"></line>
            <line x1="5" y1="12" x2="19" y2="12"></line>
        </svg>
        <span>Add Student</span>
    </a>
</div>

<div class="results-meta">
    <p>
        <?php if ($searchTerm !== ''): ?>
            Showing <strong><?= e($resultCount) ?></strong> of <strong><?= e($totalStudents) ?></strong> students for <span class="search-term">&ldquo;<?= e($searchTerm) ?>&rdquo;</span>
        <?php else: ?>
            Showing <strong><?= e($resultCount) ?></strong> of <strong><?= e($totalStudents) ?></strong> student records
        <?php endif; ?>
    </p>
    <span class="search-hint">Try <code>STU-001</code>, <code>Maria</code>, or <code>BSIT</code></span>
</div>

<section class="card">
    <div class="card-header">
        <div>
            <h3>Student Directory</h3>
            <p>Complete list of student records in the current session.</p>
        </div>
        <span class="badge badge-gray"><?= e($resultCount) ?> <?= $resultCount === 1 ? 'record' : 'records' ?></span>
    </div>

    <?php if (empty($results)): ?>
        <div class="empty-state">
            <span class="empty-icon">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </span>
            <h4>No students found</h4>
            <p><?= $searchTerm !== '' ? 'No records matched your search. Try a different name, ID, or course.' : 'The student directory is empty. Add a student to get started.' ?></p>
            <?php if ($searchTerm !== ''): ?>
                <a href="students.php" class="btn btn-secondary">Clear Search</a>
            <?php else: ?>
                <a href="add-student.php" class="btn btn-primary">Add Student</a>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="data-table records-table">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Full Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Course</th>
                        <th>Year Level</th>
                        <th>Email Address</th>
                        <th>Contact Number</th>
                        <th>Address</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $student): ?>
                        <tr>
                            <td data-label="Student ID"><span class="student-id"><?= e(strtoupper($student['id'])) ?></span></td>
                            <td data-label="First Name"><?= e($student['first_name']) ?></td>
                            <td data-label="Last Name"><?= e($student['last_name']) ?></td>
                            <td data-label="Full Name">
                                <div class="cell-name">
                                    <span class="avatar avatar-xs" style="background-color: <?= e(getAvatarColor($student['id'])) ?>;"><?= e(getInitials($student)) ?></span>
                                    <strong><?= highlightTerm(formatFullName($student), $searchTerm) ?></strong>
                                </div>
                            </td>
                            <td data-label="Age"><?= e($student['age']) ?></td>
                            <td data-label="Gender"><span class="badge badge-<?= e(strtolower($student['gender'])) ?>"><?= e($student['gender']) ?></span></td>
                            <td data-label="Course"><span class="badge course-<?= e(strtolower($student['course'])) ?>"><?= e($student['course']) ?></span></td>
                            <td data-label="Year Level"><?= e($student['year_level']) ?></td>
                            <td data-label="Email Address"><a href="mailto:<?= e($student['email']) ?>" class="table-link"><?= e($student['email']) ?></a></td>
                            <td data-label="Contact Number"><?= e(formatContact($student['contact'])) ?></td>
                            <td data-label="Address" class="address-cell"><?= e($student['address']) ?></td>
                            <td data-label="Actions" class="cell-actions">
                                <div class="action-group">
                                    <a href="student-details.php?id=<?= e(urlencode($student['id'])) ?>" class="btn-icon" title="View details" aria-label="View <?= e(formatFullName($student)) ?>">
                                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                    </a>
                                    <a href="edit-student.php?id=<?= e(urlencode($student['id'])) ?>" class="btn-icon" title="Edit student" aria-label="Edit <?= e(formatFullName($student)) ?>">
                                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M12 20h9"></path>
                                            <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                        </svg>
                                    </a>
                                    <a href="delete-student.php?id=<?= e(urlencode($student['id'])) ?>" class="btn-icon danger js-delete" title="Delete student" aria-label="Delete <?= e(formatFullName($student)) ?>" data-student-id="<?= e($student['id']) ?>" data-student-name="<?= e(formatFullName($student)) ?>">
                                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path>
                                            <path d="M10 11v6"></path>
                                            <path d="M14 11v6"></path>
                                            <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"></path>
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
