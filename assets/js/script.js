(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        var body = document.body;
        var sidebar = document.getElementById('sidebar');
        var overlay = document.getElementById('sidebarOverlay');
        var menuToggle = document.getElementById('menuToggle');
        var sidebarClose = document.getElementById('sidebarClose');

        function openSidebar() {
            if (!sidebar || !overlay || !menuToggle) {
                return;
            }

            sidebar.classList.add('open');
            overlay.classList.add('show');
            body.classList.add('sidebar-open');
            menuToggle.setAttribute('aria-expanded', 'true');
        }

        function closeSidebar() {
            if (!sidebar || !overlay || !menuToggle) {
                return;
            }

            sidebar.classList.remove('open');
            overlay.classList.remove('show');
            body.classList.remove('sidebar-open');
            menuToggle.setAttribute('aria-expanded', 'false');
        }

        if (menuToggle) {
            menuToggle.addEventListener('click', function () {
                if (sidebar && sidebar.classList.contains('open')) {
                    closeSidebar();
                } else {
                    openSidebar();
                }
            });
        }

        if (overlay) {
            overlay.addEventListener('click', closeSidebar);
        }

        if (sidebarClose) {
            sidebarClose.addEventListener('click', closeSidebar);
        }

        var modal = document.getElementById('deleteModal');
        var modalForm = document.getElementById('deleteModalForm');
        var modalName = document.getElementById('deleteStudentName');
        var modalId = document.getElementById('deleteStudentId');
        var modalCancelButton = modal ? modal.querySelector('.modal-actions .btn-secondary') : null;
        var lastDeleteTrigger = null;

        function openDeleteModal(trigger) {
            if (!modal || !modalForm || !modalName || !modalId) {
                return;
            }

            lastDeleteTrigger = trigger;
            modalName.textContent = trigger.getAttribute('data-student-name') || 'this student';
            modalId.value = trigger.getAttribute('data-student-id') || '';
            modal.classList.add('is-open');
            modal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';

            if (modalCancelButton) {
                window.setTimeout(function () {
                    modalCancelButton.focus();
                }, 30);
            }
        }

        function closeDeleteModal() {
            if (!modal) {
                return;
            }

            modal.classList.remove('is-open');
            modal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';

            if (lastDeleteTrigger) {
                lastDeleteTrigger.focus();
                lastDeleteTrigger = null;
            }
        }

        document.querySelectorAll('.js-delete').forEach(function (link) {
            link.addEventListener('click', function (event) {
                if (!modal || !modalForm) {
                    return;
                }

                event.preventDefault();
                openDeleteModal(link);
            });
        });

        if (modal) {
            modal.querySelectorAll('[data-close-modal]').forEach(function (element) {
                element.addEventListener('click', closeDeleteModal);
            });
        }

        if (modalForm) {
            modalForm.addEventListener('submit', function () {
                var submitButton = modalForm.querySelector('button[type="submit"]');

                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.textContent = 'Deleting...';
                }
            });
        }

        var toast = document.getElementById('flashToast');
        var toastClose = document.getElementById('toastClose');
        var toastTimer = null;

        function dismissToast() {
            if (!toast) {
                return;
            }

            window.clearTimeout(toastTimer);
            toast.classList.add('toast-out');

            window.setTimeout(function () {
                if (toast && toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 220);
        }

        if (toast) {
            toastTimer = window.setTimeout(dismissToast, 5000);

            if (toastClose) {
                toastClose.addEventListener('click', dismissToast);
            }
        }

        var searchInput = document.getElementById('studentSearchInput');
        var urlParams = new URLSearchParams(window.location.search);

        if (searchInput && urlParams.get('focus') === 'search') {
            window.setTimeout(function () {
                searchInput.focus();
            }, 80);
        }

        var contactInput = document.getElementById('contact');

        if (contactInput) {
            contactInput.addEventListener('input', function () {
                var digits = contactInput.value.replace(/\D/g, '').slice(0, 11);
                contactInput.value = digits;
            });
        }

        window.addEventListener('keydown', function (event) {
            if (event.key !== 'Escape') {
                return;
            }

            if (modal && modal.classList.contains('is-open')) {
                closeDeleteModal();
            } else if (sidebar && sidebar.classList.contains('open')) {
                closeSidebar();
            }
        });

        window.addEventListener('resize', function () {
            if (window.innerWidth > 1024) {
                closeSidebar();
            }
        });
    });
})();
