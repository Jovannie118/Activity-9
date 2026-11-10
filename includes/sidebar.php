<?php
$sidebarStudents = getStudents();
$sidebarTotal = countStudents($sidebarStudents);
?>
<aside class="sidebar" id="sidebar">
    <button type="button" class="icon-btn sidebar-close" id="sidebarClose" aria-label="Close navigation">
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
    </button>

    <a href="index.php" class="brand">
        <span class="brand-mark">
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M22 10 12 5 2 10l10 5 10-5z"></path>
                <path d="M6 12v5c0 1 2.5 3 6 3s6-2 6-3v-5"></path>
                <line x1="22" y1="10" x2="22" y2="16"></line>
            </svg>
        </span>
        <span class="brand-text">
            <strong>EduTrack</strong>
            <small>Student Info System</small>
        </span>
    </a>

    <nav class="sidebar-nav" aria-label="Main navigation">
        <span class="nav-label">Main Menu</span>

        <a href="index.php" class="nav-link <?= $activePage === 'dashboard' ? 'active' : '' ?>">
            <svg class="icon nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <rect x="3" y="3" width="7" height="7" rx="1.5"></rect>
                <rect x="14" y="3" width="7" height="7" rx="1.5"></rect>
                <rect x="14" y="14" width="7" height="7" rx="1.5"></rect>
                <rect x="3" y="14" width="7" height="7" rx="1.5"></rect>
            </svg>
            <span>Dashboard</span>
        </a>

        <a href="students.php" class="nav-link <?= $activePage === 'students' ? 'active' : '' ?>">
            <svg class="icon nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
            <span>Student Records</span>
        </a>

        <a href="add-student.php" class="nav-link <?= $activePage === 'add' ? 'active' : '' ?>">
            <svg class="icon nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <line x1="19" y1="8" x2="19" y2="14"></line>
                <line x1="22" y1="11" x2="16" y2="11"></line>
            </svg>
            <span>Add Student</span>
        </a>

        <a href="students.php?focus=search" class="nav-link <?= $activePage === 'search' ? 'active' : '' ?>">
            <svg class="icon nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            <span>Search Student</span>
        </a>
    </nav>

    <div class="sidebar-card">
        <span class="sidebar-card-label">Session Storage</span>
        <strong><?= e($sidebarTotal) ?> students</strong>
        <p>Records are saved in this PHP session while you use the system.</p>
        <div class="sidebar-card-footer">
            <span class="status-dot"></span>
            <span>Session active</span>
        </div>
    </div>
</aside>
