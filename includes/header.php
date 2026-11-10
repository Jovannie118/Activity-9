<?php
if (!isset($pageTitle)) {
    $pageTitle = 'Dashboard';
}

if (!isset($pageSubtitle)) {
    $pageSubtitle = 'Student Information System';
}

if (!isset($activePage)) {
    $activePage = 'dashboard';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A modern Student Information System built with PHP, HTML, CSS, and JavaScript.">
    <title><?= e($pageTitle) ?> | EduTrack</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="app-shell">
    <?php include __DIR__ . '/sidebar.php'; ?>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="main-wrapper">
        <header class="topbar">
            <div class="topbar-left">
                <button type="button" class="icon-btn menu-toggle" id="menuToggle" aria-label="Toggle navigation" aria-controls="sidebar" aria-expanded="false">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>
                <div class="topbar-heading">
                    <h1 class="page-title"><?= e($pageTitle) ?></h1>
                    <p class="page-subtitle"><?= e($pageSubtitle) ?></p>
                </div>
            </div>
            <div class="topbar-right">
                <div class="date-chip">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect x="3" y="4" width="18" height="18" rx="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                    <span><?= e(date('F j, Y')) ?></span>
                </div>
                <div class="admin-chip">
                    <span class="admin-avatar">AD</span>
                    <div class="admin-text">
                        <strong>Admin</strong>
                        <span>Registrar</span>
                    </div>
                </div>
            </div>
        </header>

        <main class="content">
