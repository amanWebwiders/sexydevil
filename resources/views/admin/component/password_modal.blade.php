<!-- Manage User / Ad Password Modal -->
<style>
    #managePasswordModal .modal-content {
        background: #ffffff !important;
        border: none !important;
        border-radius: 14px !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
        overflow: hidden !important;
    }
    #managePasswordModal .modal-header {
        background: #111827 !important;
        border-bottom: 1px solid #1f2937 !important;
        padding: 16px 22px !important;
    }
    #managePasswordModal .modal-title {
        color: #f9fafb !important;
        font-size: 16px !important;
        font-weight: 700 !important;
        display: flex !important;
        align-items: center !important;
        gap: 10px !important;
        margin: 0 !important;
    }
    #managePasswordModal .modal-header .btn-close {
        filter: invert(1) grayscale(100%) brightness(200%) !important;
        opacity: 0.8 !important;
        box-shadow: none !important;
    }
    #managePasswordModal .modal-header .btn-close:hover {
        opacity: 1 !important;
    }
    #managePasswordModal .pw-user-card {
        background: #f8fafc !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 10px !important;
        padding: 12px 16px !important;
    }
    #managePasswordModal .pw-user-name {
        color: #0f172a !important;
        font-weight: 700 !important;
        font-size: 15px !important;
    }
    #managePasswordModal .pw-user-email {
        color: #64748b !important;
        font-size: 13px !important;
    }
    #managePasswordModal .pw-card-current {
        background: #f0fdf4 !important;
        border: 1px solid #bbf7d0 !important;
        border-radius: 10px !important;
        padding: 14px 16px !important;
    }
    #managePasswordModal .pw-card-current.is-legacy {
        background: #fefce8 !important;
        border-color: #fef08a !important;
    }
    #managePasswordModal .pw-label {
        color: #1e293b !important;
        font-weight: 700 !important;
        font-size: 13px !important;
        margin-bottom: 6px !important;
        display: block !important;
    }
    #managePasswordModal .pw-input {
        background: #ffffff !important;
        color: #0f172a !important;
        border: 1px solid #cbd5e1 !important;
        font-family: Consolas, 'Courier New', monospace !important;
        font-weight: 600 !important;
        font-size: 15px !important;
        letter-spacing: 0.5px !important;
        padding: 10px 14px !important;
        border-radius: 6px 0 0 6px !important;
    }
    #managePasswordModal .pw-input:focus {
        border-color: #2563eb !important;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15) !important;
    }
    #managePasswordModal .btn-pw-eye {
        background: #f1f5f9 !important;
        border: 1px solid #cbd5e1 !important;
        border-left: none !important;
        color: #475569 !important;
        padding: 0 14px !important;
        border-radius: 0 !important;
        cursor: pointer !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
    }
    #managePasswordModal .btn-pw-eye:hover {
        background: #e2e8f0 !important;
        color: #0f172a !important;
    }
    #managePasswordModal .btn-pw-action-copy {
        background: #f1f5f9 !important;
        border: 1px solid #cbd5e1 !important;
        border-left: none !important;
        color: #475569 !important;
        padding: 0 14px !important;
        border-radius: 0 6px 6px 0 !important;
        cursor: pointer !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
    }
    #managePasswordModal .btn-pw-action-copy:hover {
        background: #e2e8f0 !important;
        color: #0f172a !important;
    }
    #managePasswordModal .btn-pw-email {
        background: #059669 !important;
        border: 1px solid #059669 !important;
        color: #ffffff !important;
        font-weight: 600 !important;
        font-size: 12.5px !important;
        border-radius: 6px !important;
        padding: 6px 14px !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
        cursor: pointer !important;
        transition: all 0.15s ease !important;
    }
    #managePasswordModal .btn-pw-email:hover {
        background: #047857 !important;
        border-color: #047857 !important;
        color: #ffffff !important;
    }
    #managePasswordModal .btn-pw-email:disabled {
        background: #9ca3af !important;
        border-color: #9ca3af !important;
        cursor: not-allowed !important;
        opacity: 0.7 !important;
    }
    #managePasswordModal .btn-pw-generate {
        background: #2563eb !important;
        border: 1px solid #2563eb !important;
        color: #ffffff !important;
        font-weight: 600 !important;
        font-size: 13px !important;
        border-radius: 6px !important;
        padding: 8px 16px !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
        cursor: pointer !important;
        transition: background 0.15s ease !important;
    }
    #managePasswordModal .btn-pw-generate:hover {
        background: #1d4ed8 !important;
        border-color: #1d4ed8 !important;
        color: #ffffff !important;
    }
    #managePasswordModal .btn-pw-copy {
        background: #f8fafc !important;
        border: 1px solid #cbd5e1 !important;
        color: #334155 !important;
        font-weight: 600 !important;
        font-size: 13px !important;
        border-radius: 6px !important;
        padding: 8px 16px !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
        cursor: pointer !important;
        transition: background 0.15s ease !important;
    }
    #managePasswordModal .btn-pw-copy:hover {
        background: #e2e8f0 !important;
        color: #0f172a !important;
    }
    #managePasswordModal .pw-divider {
        position: relative;
        text-align: center;
        margin: 20px 0 16px 0;
    }
    #managePasswordModal .pw-divider hr {
        border-top: 1px solid #e2e8f0;
        margin: 0;
    }
    #managePasswordModal .pw-divider span {
        position: absolute;
        top: -10px;
        left: 50%;
        transform: translateX(-50%);
        background: #ffffff;
        padding: 0 12px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.5px;
        color: #64748b;
        text-transform: uppercase;
    }
    #managePasswordModal .pw-email-note {
        color: #475569 !important;
        font-size: 13px !important;
        font-weight: 500 !important;
    }
    #managePasswordModal .modal-footer {
        background: #f8fafc !important;
        border-top: 1px solid #e2e8f0 !important;
        padding: 14px 20px !important;
    }
    #managePasswordModal .btn-pw-cancel {
        background: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        color: #475569 !important;
        font-weight: 600 !important;
        font-size: 14px !important;
        border-radius: 6px !important;
        padding: 8px 20px !important;
        cursor: pointer !important;
    }
    #managePasswordModal .btn-pw-cancel:hover {
        background: #f1f5f9 !important;
        color: #0f172a !important;
    }
    #managePasswordModal .btn-pw-save {
        background: #dc2626 !important;
        border: 1px solid #dc2626 !important;
        color: #ffffff !important;
        font-weight: 600 !important;
        font-size: 14px !important;
        border-radius: 6px !important;
        padding: 8px 24px !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
        cursor: pointer !important;
    }
    #managePasswordModal .btn-pw-save:hover {
        background: #b91c1c !important;
        border-color: #b91c1c !important;
        color: #ffffff !important;
    }
</style>

<div class="modal fade" id="managePasswordModal" tabindex="-1" aria-labelledby="managePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="managePasswordModalLabel">
                    <i class="fa-solid fa-key" style="color: #f59e0b;"></i> Manage Account Password
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="managePasswordForm">
                @csrf
                <input type="hidden" id="modalUserId" name="user_id">
                <div class="modal-body p-4">
                    <!-- User Card -->
                    <div class="pw-user-card d-flex align-items-center mb-3">
                        <div class="me-3">
                            <i class="fa-solid fa-user-circle fa-2x" style="color: #94a3b8;"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="pw-user-name" id="modalUserName">-</div>
                            <div class="pw-user-email" id="modalUserEmail">-</div>
                        </div>
                    </div>

                    <!-- Current Password Box -->
                    <div class="pw-card-current mb-3" id="pwCurrentCard">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <label class="pw-label mb-0" style="color: #0f172a !important;">
                                <i class="fa-solid fa-shield-halved text-success me-1"></i> Current Password
                            </label>
                            <span id="pwStatusBadge" class="badge bg-success" style="font-size: 11px; padding: 4px 8px;">Saved</span>
                        </div>
                        
                        <div class="input-group">
                            <input type="password" class="form-control pw-input" id="modalCurrentPassword" readonly placeholder="Loading password..." style="background: #ffffff !important; cursor: text;">
                            <button class="btn btn-pw-eye" type="button" id="toggleCurrentPasswordVisibility" title="Show/Hide Current Password">
                                <i class="fa-solid fa-eye" id="toggleCurrentPasswordIcon"></i>
                            </button>
                            <button class="btn btn-pw-action-copy" type="button" id="btnCopyCurrentPassword" title="Copy Current Password">
                                <i class="fa-solid fa-copy"></i>
                            </button>
                        </div>

                        <!-- Action row for Current Password -->
                        <div class="d-flex align-items-center justify-content-between mt-2 pt-1 flex-wrap gap-2">
                            <button type="button" class="btn btn-pw-email" id="btnEmailCurrentPassword">
                                <i class="fa-solid fa-paper-plane"></i> Email Current Password to User
                            </button>
                            <span id="pwLegacyNotice" class="text-warning small d-none" style="font-weight: 600;">
                                <i class="fa-solid fa-triangle-exclamation"></i> Encrypted legacy password
                            </span>
                        </div>
                        <div id="pwLegacyHelpText" class="text-muted small mt-1 d-none">
                            <em>This account was registered before password tracking. Please enter a new password below to update and track it.</em>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="pw-divider">
                        <hr>
                        <span>Change / Set New Password</span>
                    </div>

                    <!-- New Password Input -->
                    <div class="mb-3">
                        <label class="pw-label" for="modalNewPassword">
                            New Password <span class="text-muted fw-normal">(min 6 chars)</span>
                        </label>
                        <div class="input-group">
                            <input type="password" class="form-control pw-input" id="modalNewPassword" name="password" placeholder="Enter new password to change..." minlength="6">
                            <button class="btn btn-pw-eye" type="button" id="toggleNewPasswordVisibility" title="Show/Hide New Password" style="border-radius: 0 6px 6px 0 !important; border-left: none !important;">
                                <i class="fa-solid fa-eye" id="toggleNewPasswordIcon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Quick Tools -->
                    <div class="d-flex gap-2 mb-3">
                        <button type="button" class="btn btn-pw-generate" id="btnGeneratePassword">
                            <i class="fa-solid fa-wand-magic-sparkles"></i> Generate Strong Password
                        </button>
                        <button type="button" class="btn btn-pw-copy" id="btnCopyNewPassword">
                            <i class="fa-solid fa-copy"></i> Copy New
                        </button>
                    </div>

                    <!-- Send Email Notification Toggle on Update -->
                    <div class="form-check form-switch mt-3">
                        <input class="form-check-input" type="checkbox" id="modalSendEmail" name="send_email" value="1" style="cursor: pointer;">
                        <label class="form-check-label pw-email-note" for="modalSendEmail" style="cursor: pointer;">
                            Send updated password notification to user's email
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-pw-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-pw-save" id="btnSavePassword">
                        <i class="fa-solid fa-floppy-disk"></i> Save Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    let currentActiveButton = null;

    // Helper to update current password state in modal
    function setCurrentPasswordUI(password, hasPassword) {
        const $input = $('#modalCurrentPassword');
        const $card = $('#pwCurrentCard');
        const $badge = $('#pwStatusBadge');
        const $btnEmail = $('#btnEmailCurrentPassword');
        const $legacyNotice = $('#pwLegacyNotice');
        const $legacyHelp = $('#pwLegacyHelpText');

        if (hasPassword && password) {
            $input.val(password);
            $input.attr('type', 'password');
            $('#toggleCurrentPasswordIcon').removeClass('fa-eye-slash').addClass('fa-eye');
            $card.removeClass('is-legacy');
            $badge.removeClass('bg-warning text-dark').addClass('bg-success text-white').text('Saved');
            $btnEmail.prop('disabled', false).attr('title', 'Send current password to registered email');
            $legacyNotice.addClass('d-none');
            $legacyHelp.addClass('d-none');
        } else {
            $input.val('');
            $input.attr('placeholder', 'Encrypted / Not stored in plain text');
            $input.attr('type', 'text');
            $card.addClass('is-legacy');
            $badge.removeClass('bg-success text-white').addClass('bg-warning text-dark').text('Not Tracked');
            $btnEmail.prop('disabled', true).attr('title', 'Set a new password below first to enable emailing');
            $legacyNotice.removeClass('d-none');
            $legacyHelp.removeClass('d-none');
        }
    }

    // Open password modal on click
    $(document).on('click', '.password-btn', function() {
        currentActiveButton = $(this);
        const userId = $(this).data('id');
        const userName = $(this).data('name') || 'User #' + userId;
        const userEmail = $(this).data('email') || '-';
        const prefilledPassword = $(this).data('password') || '';

        $('#modalUserId').val(userId);
        $('#modalUserName').text(userName);
        $('#modalUserEmail').text(userEmail);
        $('#modalNewPassword').val('');
        $('#modalNewPassword').attr('type', 'password');
        $('#toggleNewPasswordIcon').removeClass('fa-eye-slash').addClass('fa-eye');
        $('#modalSendEmail').prop('checked', false);

        // If prefilled password exists on button, use it immediately
        if (prefilledPassword) {
            setCurrentPasswordUI(prefilledPassword, true);
        } else {
            setCurrentPasswordUI('', false);
        }

        // Fetch latest password state from server to guarantee sync
        let fetchUrl = '{{ route("admin.users.get-password", ":id") }}'.replace(':id', userId);
        $.ajax({
            url: fetchUrl,
            type: 'GET',
            success: function(res) {
                if (res && res.status) {
                    if (res.has_password && res.password) {
                        setCurrentPasswordUI(res.password, true);
                        if (currentActiveButton) {
                            currentActiveButton.data('password', res.password);
                            currentActiveButton.attr('data-password', res.password);
                        }
                    } else {
                        setCurrentPasswordUI('', false);
                    }
                }
            },
            error: function(err) {
                console.warn('Could not fetch user password state:', err);
            }
        });

        const modalEl = document.getElementById('managePasswordModal');
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();
    });

    // Toggle current password visibility
    $('#toggleCurrentPasswordVisibility').on('click', function() {
        const $pw = $('#modalCurrentPassword');
        const $icon = $('#toggleCurrentPasswordIcon');
        if (!$pw.val()) return;

        if ($pw.attr('type') === 'password') {
            $pw.attr('type', 'text');
            $icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            $pw.attr('type', 'password');
            $icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    // Copy current password to clipboard
    $('#btnCopyCurrentPassword').on('click', function() {
        const password = $('#modalCurrentPassword').val();
        if (!password) {
            Swal.fire({
                icon: 'warning',
                title: 'No Password Available',
                text: 'This account does not have a readable password stored. Please set a new password below.',
                timer: 2500,
                showConfirmButton: false
            });
            return;
        }
        navigator.clipboard.writeText(password).then(() => {
            Swal.fire({
                icon: 'success',
                title: 'Current Password Copied!',
                text: password,
                timer: 1800,
                showConfirmButton: false
            });
        }).catch(() => {
            Swal.fire({
                icon: 'info',
                title: 'Current Password',
                text: password
            });
        });
    });

    // Email Current Password to User
    $('#btnEmailCurrentPassword').on('click', function() {
        const userId = $('#modalUserId').val();
        const userEmail = $('#modalUserEmail').text();
        const currentPw = $('#modalCurrentPassword').val();
        const $btn = $(this);

        if (!currentPw) {
            Swal.fire({
                icon: 'warning',
                title: 'Current Password Not Available',
                text: 'Cannot email password because it is encrypted or not set. Please set a new password below first.'
            });
            return;
        }

        Swal.fire({
            title: 'Send Current Password?',
            html: `<p>Send the current password to user's email: <strong>${userEmail}</strong>?</p>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, Send Email',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#059669'
        }).then((result) => {
            if (result.isConfirmed) {
                let sendUrl = '{{ route("admin.users.send-current-password", ":id") }}'.replace(':id', userId);
                $btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin me-1"></i> Sending...');

                $.ajax({
                    url: sendUrl,
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(resp) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Email Sent!',
                            text: resp.message || 'Current password has been sent to ' + userEmail + '.',
                            confirmButtonColor: '#059669'
                        });
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        let errMsg = 'Failed to send password email.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errMsg = xhr.responseJSON.message;
                        }
                        Swal.fire('Error!', errMsg, 'error');
                    },
                    complete: function() {
                        $btn.prop('disabled', false).html('<i class="fa-solid fa-paper-plane"></i> Email Current Password to User');
                    }
                });
            }
        });
    });

    // Toggle new password visibility
    $('#toggleNewPasswordVisibility').on('click', function() {
        const $pw = $('#modalNewPassword');
        const $icon = $('#toggleNewPasswordIcon');
        if ($pw.attr('type') === 'password') {
            $pw.attr('type', 'text');
            $icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            $pw.attr('type', 'password');
            $icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    // Generate random strong password
    $('#btnGeneratePassword').on('click', function() {
        const chars = "abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789!@#$%&*";
        let newPassword = "";
        for (let i = 0; i < 10; i++) {
            newPassword += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        $('#modalNewPassword').val(newPassword);
        $('#modalNewPassword').attr('type', 'text');
        $('#toggleNewPasswordIcon').removeClass('fa-eye').addClass('fa-eye-slash');
    });

    // Copy new password to clipboard
    $('#btnCopyNewPassword').on('click', function() {
        const password = $('#modalNewPassword').val();
        if (!password) {
            Swal.fire({
                icon: 'warning',
                title: 'Empty Password',
                text: 'Please enter or generate a new password first.',
                timer: 2000,
                showConfirmButton: false
            });
            return;
        }
        navigator.clipboard.writeText(password).then(() => {
            Swal.fire({
                icon: 'success',
                title: 'Copied!',
                text: 'New password copied to clipboard: ' + password,
                timer: 2000,
                showConfirmButton: false
            });
        }).catch(() => {
            Swal.fire({
                icon: 'info',
                title: 'New Password',
                text: password
            });
        });
    });

    // Submit password update
    $('#managePasswordForm').on('submit', function(e) {
        e.preventDefault();
        const userId = $('#modalUserId').val();
        const password = $('#modalNewPassword').val();
        const sendEmail = $('#modalSendEmail').is(':checked') ? 1 : 0;
        const $btn = $('#btnSavePassword');

        if (!password || password.length < 6) {
            Swal.fire('Invalid Password', 'Please enter a new password with at least 6 characters.', 'warning');
            return;
        }

        let url = '{{ route("admin.users.change-password", ":id") }}'.replace(':id', userId);
        $btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin me-1"></i> Saving...');

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                password: password,
                send_email: sendEmail
            },
            success: function(response) {
                // Update current password display immediately in the open modal
                setCurrentPasswordUI(password, true);

                // Update data-password on the table row button
                if (currentActiveButton) {
                    currentActiveButton.data('password', password);
                    currentActiveButton.attr('data-password', password);
                }

                // Clear new password input
                $('#modalNewPassword').val('');
                $('#modalSendEmail').prop('checked', false);

                let emailNotice = sendEmail ? '<br><span class="text-success"><i class="fa-solid fa-check"></i> Email notification was sent to user.</span>' : '';

                Swal.fire({
                    icon: 'success',
                    title: 'Password Updated!',
                    html: `<p>${response.message}</p>
                           <p class="mt-2 mb-0"><strong>Current Password:</strong> <code style="font-size: 16px; color: #dc2626; background: #fee2e2; padding: 3px 8px; border-radius: 4px;">${password}</code></p>
                           ${emailNotice}`,
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#dc2626'
                });
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                let msg = 'Failed to update password.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                Swal.fire('Error!', msg, 'error');
            },
            complete: function() {
                $btn.prop('disabled', false).html('<i class="fa-solid fa-floppy-disk me-1"></i> Save Password');
            }
        });
    });
});
</script>
