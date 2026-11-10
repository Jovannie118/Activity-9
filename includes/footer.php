        </main>

        <footer class="app-footer">
            <span>&copy; <?= e(date('Y')) ?> EduTrack &mdash; Student Information System</span>
            <span>Built with PHP, HTML, CSS &amp; JavaScript</span>
        </footer>
    </div>
</div>

<div class="modal" id="deleteModal" aria-hidden="true">
    <div class="modal-backdrop" data-close-modal></div>
    <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="deleteModalTitle">
        <div class="modal-icon">
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <polyline points="3 6 5 6 21 6"></polyline>
                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path>
                <path d="M10 11v6"></path>
                <path d="M14 11v6"></path>
                <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"></path>
            </svg>
        </div>
        <h2 id="deleteModalTitle">Delete student record?</h2>
        <p>You are about to delete <strong id="deleteStudentName">this student</strong>. This action cannot be undone.</p>
        <form method="post" action="delete-student.php" id="deleteModalForm">
            <input type="hidden" name="id" id="deleteStudentId" value="">
            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" data-close-modal>Cancel</button>
                <button type="submit" class="btn btn-danger">Delete Student</button>
            </div>
        </form>
    </div>
</div>

<?php $flash = getFlash(); ?>
<?php if ($flash !== null): ?>
    <div class="toast toast-<?= e($flash['type']) ?>" id="flashToast" role="status">
        <span class="toast-icon">
            <?php if ($flash['type'] === 'success'): ?>
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            <?php else: ?>
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
            <?php endif; ?>
        </span>
        <p><?= e($flash['message']) ?></p>
        <button type="button" class="toast-close" id="toastClose" aria-label="Dismiss notification">
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>
<?php endif; ?>

<script src="assets/js/script.js"></script>
</body>
</html>
