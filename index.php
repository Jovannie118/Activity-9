<?php
require_once __DIR__ . '/functions.php';

$students = getStudents();
$totalStudents = countStudents($students);
$maleStudents = countByGender($students, 'Male');
$femaleStudents = countByGender($students, 'Female');
$averageAge = averageAge($students);
$recentStudents = getRecentStudents($students, 5);
$courseCounts = countByCourse($students);
$courseTotal = count($courseCounts);

$activePage = 'dashboard';
$pageTitle = 'Dashboard';
$pageSubtitle = 'Overview of your student records';

include __DIR__ . '/includes/header.php';
?>

<section class="welcome-banner">
    <div class="welcome-copy">
        <span class="eyebrow">Student Information System</span>
        <h2>Welcome back, Admin</h2>
        <p>You currently have <strong><?= e($totalStudents) ?></strong> student records stored in this session. Keep your student directory complete and up to date.</p>
        <div class="welcome-actions">
            <a href="add-student.php" class="btn btn-primary">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                <span>Add New Student</span>
            </a>
            <a href="students.php" class="btn btn-secondary">View All Records</a>
        </div>
    </div>
    <div class="welcome-art" aria-hidden="true">
        <div class="art-circle art-circle-one"></div>
        <div class="art-circle art-circle-two"></div>
        <div class="art-card">
            <span class="art-card-label">Total Students</span>
            <strong><?= e($totalStudents) ?></strong>
            <span class="art-card-meta"><?= e($courseTotal) ?> courses represented</span>
        </div>
    </div>
</section>

<section class="stats-grid" aria-label="Student statistics">
    <article class="stat-card">
        <div class="stat-icon stat-blue">
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
        </div>
        <div class="stat-info">
            <span class="stat-label">Total Students</span>
            <strong class="stat-value"><?= e($totalStudents) ?></strong>
            <span class="stat-meta">Active student records</span>
        </div>
    </article>

    <article class="stat-card">
        <div class="stat-icon stat-teal">
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <circle cx="10" cy="14" r="5"></circle>
                <line x1="19" y1="5" x2="13.6" y2="10.4"></line>
                <polyline points="19 5 19 10 14 10"></polyline>
            </svg>
        </div>
        <div class="stat-info">
            <span class="stat-label">Male Students</span>
            <strong class="stat-value"><?= e($maleStudents) ?></strong>
            <span class="stat-meta"><?= e(percentage($maleStudents, $totalStudents)) ?>% of all students</span>
        </div>
    </article>

    <article class="stat-card">
        <div class="stat-icon stat-rose">
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <circle cx="12" cy="9" r="5"></circle>
                <line x1="12" y1="14" x2="12" y2="22"></line>
                <line x1="8" y1="19" x2="16" y2="19"></line>
            </svg>
        </div>
        <div class="stat-info">
            <span class="stat-label">Female Students</span>
            <strong class="stat-value"><?= e($femaleStudents) ?></strong>
            <span class="stat-meta"><?= e(percentage($femaleStudents, $totalStudents)) ?>% of all students</span>
        </div>
    </article>

    <article class="stat-card">
        <div class="stat-icon stat-amber">
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <rect x="3" y="4" width="18" height="18" rx="2"></rect>
                <line x1="16" y1="2" x2="16" y2="6"></line>
                <line x1="8" y1="2" x2="8" y2="6"></line>
                <line x1="3" y1="10" x2="21" y2="10"></line>
            </svg>
        </div>
        <div class="stat-info">
            <span class="stat-label">Average Age</span>
            <strong class="stat-value"><?= e(number_format($averageAge, 1)) ?></strong>
            <span class="stat-meta">Years old across records</span>
        </div>
    </article>
</section>

<div class="dashboard-grid">
    <section class="card">
        <div class="card-header">
            <div>
                <h3>Recently Added Students</h3>
                <p>The latest records in your student directory.</p>
            </div>
            <a href="students.php" class="card-link">View all</a>
        </div>

        <?php if (empty($recentStudents)): ?>
            <div class="empty-state compact">
                <span class="empty-icon">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </span>
                <h4>No student records yet</h4>
                <p>Add your first student to see it here.</p>
                <a href="add-student.php" class="btn btn-primary">Add Student</a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="data-table recent-table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Course</th>
                            <th>Year Level</th>
                            <th>Age</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentStudents as $student): ?>
                            <tr>
                                <td>
                                    <div class="cell-name">
                                        <span class="avatar avatar-sm" style="background-color: <?= e(getAvatarColor($student['id'])) ?>;"><?= e(getInitials($student)) ?></span>
                                        <div>
                                            <strong><?= e(formatFullName($student)) ?></strong>
                                            <span class="cell-sub"><?= e($student['id']) ?> &bull; <?= e($student['email']) ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge course-<?= e(strtolower($student['course'])) ?>"><?= e($student['course']) ?></span></td>
                                <td><?= e($student['year_level']) ?></td>
                                <td><?= e($student['age']) ?></td>
                                <td class="text-right">
                                    <a href="student-details.php?id=<?= e(urlencode($student['id'])) ?>" class="btn btn-sm btn-secondary">View</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </section>

    <section class="card">
        <div class="card-header">
            <div>
                <h3>Student Record Overview</h3>
                <p>Distribution of students by course and gender.</p>
            </div>
        </div>

        <div class="card-body">
            <div class="overview-summary">
                <div>
                    <span>Total Records</span>
                    <strong><?= e($totalStudents) ?></strong>
                </div>
                <div>
                    <span>Courses</span>
                    <strong><?= e($courseTotal) ?></strong>
                </div>
                <div>
                    <span>Average Age</span>
                    <strong><?= e(number_format($averageAge, 1)) ?></strong>
                </div>
            </div>

            <h4 class="overview-title">Students per Course</h4>

            <?php if (empty($courseCounts)): ?>
                <p class="muted-text">Course information will appear once students are added.</p>
            <?php else: ?>
                <div class="progress-list">
                    <?php foreach ($courseCounts as $course => $count): ?>
                        <div class="progress-row">
                            <div class="progress-head">
                                <span class="progress-label">
                                    <span class="course-dot course-dot-<?= e(strtolower($course)) ?>"></span>
                                    <?= e($course) ?>
                                </span>
                                <span class="progress-value"><?= e($count) ?> <?= $count === 1 ? 'student' : 'students' ?></span>
                            </div>
                            <div class="progress-track">
                                <span class="progress-fill course-fill-<?= e(strtolower($course)) ?>" style="width: <?= e(percentage($count, $totalStudents)) ?>%;"></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <h4 class="overview-title">Gender Distribution</h4>
            <div class="gender-split-bar" aria-hidden="true">
                <span class="gender-male" style="width: <?= e(percentage($maleStudents, $totalStudents)) ?>%;"></span>
                <span class="gender-female" style="width: <?= e(percentage($femaleStudents, $totalStudents)) ?>%;"></span>
            </div>
            <div class="gender-legend">
                <span><i class="legend-dot male-dot"></i> Male <strong><?= e($maleStudents) ?></strong></span>
                <span><i class="legend-dot female-dot"></i> Female <strong><?= e($femaleStudents) ?></strong></span>
            </div>
        </div>
    </section>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
