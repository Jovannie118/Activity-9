<?php
$isEdit = ($formMode ?? 'add') === 'edit';
$formAction = $formAction ?? 'add-student.php';
$submitLabel = $submitLabel ?? 'Save Student';
$cancelUrl = $cancelUrl ?? 'students.php';
$studentId = $studentId ?? '';
?>
<div class="form-layout">
    <section class="card">
        <div class="card-body form-card-body">
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger" role="alert">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                        <line x1="12" y1="9" x2="12" y2="13"></line>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                    <div>
                        <strong>Please correct the errors below.</strong>
                        <p><?= e(count($errors)) ?> field<?= count($errors) === 1 ? '' : 's' ?> need<?= count($errors) === 1 ? 's' : '' ?> your attention.</p>
                    </div>
                </div>
            <?php endif; ?>

            <form method="post" action="<?= e($formAction) ?>" class="student-form">
                <?php if ($isEdit): ?>
                    <input type="hidden" name="id" value="<?= e($studentId) ?>">
                <?php endif; ?>

                <div class="form-section">
                    <div class="form-section-title">
                        <span class="section-icon">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </span>
                        <div>
                            <h3>Personal Information</h3>
                            <p>Basic details of the student.</p>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="first_name">First Name <span class="required">*</span></label>
                            <input type="text" id="first_name" name="first_name" value="<?= e($formData['first_name'] ?? '') ?>" class="<?= isset($errors['first_name']) ? 'input-error' : '' ?>" maxlength="50" required>
                            <?php if (isset($errors['first_name'])): ?>
                                <span class="field-error"><?= e($errors['first_name']) ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="last_name">Last Name <span class="required">*</span></label>
                            <input type="text" id="last_name" name="last_name" value="<?= e($formData['last_name'] ?? '') ?>" class="<?= isset($errors['last_name']) ? 'input-error' : '' ?>" maxlength="50" required>
                            <?php if (isset($errors['last_name'])): ?>
                                <span class="field-error"><?= e($errors['last_name']) ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="age">Age <span class="required">*</span></label>
                            <input type="number" id="age" name="age" value="<?= e($formData['age'] ?? '') ?>" class="<?= isset($errors['age']) ? 'input-error' : '' ?>" min="15" max="100" required>
                            <?php if (isset($errors['age'])): ?>
                                <span class="field-error"><?= e($errors['age']) ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="gender">Gender <span class="required">*</span></label>
                            <select id="gender" name="gender" class="<?= isset($errors['gender']) ? 'input-error' : '' ?>" required>
                                <option value="">Select gender</option>
                                <?php foreach (getGenderOptions() as $genderOption): ?>
                                    <option value="<?= e($genderOption) ?>" <?= ($formData['gender'] ?? '') === $genderOption ? 'selected' : '' ?>><?= e($genderOption) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (isset($errors['gender'])): ?>
                                <span class="field-error"><?= e($errors['gender']) ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group full">
                            <label for="address">Complete Address <span class="required">*</span></label>
                            <textarea id="address" name="address" rows="3" class="<?= isset($errors['address']) ? 'input-error' : '' ?>" maxlength="150" required><?= e($formData['address'] ?? '') ?></textarea>
                            <?php if (isset($errors['address'])): ?>
                                <span class="field-error"><?= e($errors['address']) ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-section-title">
                        <span class="section-icon">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M22 10 12 5 2 10l10 5 10-5z"></path>
                                <path d="M6 12v5c0 1 2.5 3 6 3s6-2 6-3v-5"></path>
                                <line x1="22" y1="10" x2="22" y2="16"></line>
                            </svg>
                        </span>
                        <div>
                            <h3>Academic Information</h3>
                            <p>Enrollment and course details.</p>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="student_id">Student ID</label>
                            <input type="text" id="student_id" value="<?= e($studentId) ?>" class="readonly-input" readonly>
                            <span class="helper-text"><?= $isEdit ? 'The student ID cannot be changed.' : 'This ID is generated automatically.' ?></span>
                        </div>

                        <div class="form-group">
                            <label for="course">Course <span class="required">*</span></label>
                            <select id="course" name="course" class="<?= isset($errors['course']) ? 'input-error' : '' ?>" required>
                                <option value="">Select course</option>
                                <?php foreach (getCourses() as $course): ?>
                                    <option value="<?= e($course) ?>" <?= ($formData['course'] ?? '') === $course ? 'selected' : '' ?>><?= e($course) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (isset($errors['course'])): ?>
                                <span class="field-error"><?= e($errors['course']) ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="year_level">Year Level <span class="required">*</span></label>
                            <select id="year_level" name="year_level" class="<?= isset($errors['year_level']) ? 'input-error' : '' ?>" required>
                                <option value="">Select year level</option>
                                <?php foreach (getYearLevels() as $yearLevel): ?>
                                    <option value="<?= e($yearLevel) ?>" <?= ($formData['year_level'] ?? '') === $yearLevel ? 'selected' : '' ?>><?= e($yearLevel) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (isset($errors['year_level'])): ?>
                                <span class="field-error"><?= e($errors['year_level']) ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-section-title">
                        <span class="section-icon">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M4 4h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                        </span>
                        <div>
                            <h3>Contact Information</h3>
                            <p>Ways to reach the student.</p>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="email">Email Address <span class="required">*</span></label>
                            <input type="email" id="email" name="email" value="<?= e($formData['email'] ?? '') ?>" class="<?= isset($errors['email']) ? 'input-error' : '' ?>" maxlength="100" required>
                            <?php if (isset($errors['email'])): ?>
                                <span class="field-error"><?= e($errors['email']) ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="contact">Contact Number <span class="required">*</span></label>
                            <input type="tel" id="contact" name="contact" value="<?= e($formData['contact'] ?? '') ?>" class="<?= isset($errors['contact']) ? 'input-error' : '' ?>" maxlength="11" inputmode="numeric" placeholder="09XXXXXXXXX" required>
                            <?php if (isset($errors['contact'])): ?>
                                <span class="field-error"><?= e($errors['contact']) ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="<?= e($cancelUrl) ?>" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                            <polyline points="17 21 17 13 7 13 7 21"></polyline>
                            <polyline points="7 3 7 8 15 8"></polyline>
                        </svg>
                        <span><?= e($submitLabel) ?></span>
                    </button>
                </div>
            </form>
        </div>
    </section>

    <aside class="form-aside">
        <div class="card">
            <div class="card-body">
                <div class="aside-heading">
                    <span class="section-icon">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                            <line x1="7" y1="10" x2="11" y2="10"></line>
                            <line x1="7" y1="14" x2="15" y2="14"></line>
                            <circle cx="17" cy="10" r="2"></circle>
                        </svg>
                    </span>
                    <div>
                        <h3>Record Guidelines</h3>
                        <p>Quick reminders before saving.</p>
                    </div>
                </div>

                <div class="id-preview">
                    <span>Student ID</span>
                    <strong><?= e($studentId) ?></strong>
                </div>

                <ul class="tips-list">
                    <li>
                        <span class="tip-check">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </span>
                        <span>All fields are required and validated before saving.</span>
                    </li>
                    <li>
                        <span class="tip-check">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </span>
                        <span>Contact numbers must be 11 digits and start with 09.</span>
                    </li>
                    <li>
                        <span class="tip-check">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </span>
                        <span>Each email address can only be used by one student.</span>
                    </li>
                    <li>
                        <span class="tip-check">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </span>
                        <span>Names and addresses are automatically formatted.</span>
                    </li>
                </ul>

                <div class="aside-note">
                    <strong>Session storage</strong>
                    <p>This record is stored in the current PHP session and will remain available as you navigate the system.</p>
                </div>
            </div>
        </div>
    </aside>
</div>
