<!-- Manage User / Ad Password Modal -->
<style>
    #managePasswordModal .modal-content {
        background: #ffffff !important;
        border: none !important;
        border-radius: 12px !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
        overflow: hidden !important;
    }
    #managePasswordModal .modal-header {
        background: #111827 !important;
        border-bottom: 1px solid #1f2937 !important;
        padding: 16px 20px !important;
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
        border-radius: 8px !important;
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
    #managePasswordModal .pw-label {
        color: #1e293b !important;
        font-weight: 600 !important;
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
        padding: 0 16px !important;
        border-radius: 0 6px 6px 0 !important;
        cursor: pointer !important;
    }
    #managePasswordModal .btn-pw-eye:hover {
        background: #e2e8f0 !important;
        color: #0f172a !important;
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
                    <div class="pw-user-card d-flex align-items-center mb-3">
                        <div class="me-3">
                            <i class="fa-solid fa-user-circle fa-2x" style="color: #94a3b8;"></i>
                        </div>
                        <div>
                            <div class="pw-user-name" id="modalUserName">-</div>
                            <div class="pw-user-email" id="modalUserEmail">-</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="pw-label">New Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control pw-input" id="modalNewPassword" name="password" placeholder="Enter new password (min 6 chars)" minlength="6" required>
                            <button class="btn btn-pw-eye" type="button" id="togglePasswordVisibility" title="Show/Hide Password">
                                <i class="fa-solid fa-eye" id="togglePasswordIcon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mb-3">
                        <button type="button" class="btn btn-pw-generate" id="btnGeneratePassword">
                            <i class="fa-solid fa-wand-magic-sparkles"></i> Generate Strong Password
                        </button>
                        <button type="button" class="btn btn-pw-copy" id="btnCopyPassword">
                            <i class="fa-solid fa-copy"></i> Copy Password
                        </button>
                    </div>

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
    // Open password modal on click
    $(document).on('click', '.password-btn', function() {
        const userId = $(this).data('id');
        const userName = $(this).data('name') || 'User #' + userId;
        const userEmail = $(this).data('email') || '-';

        $('#modalUserId').val(userId);
        $('#modalUserName').text(userName);
        $('#modalUserEmail').text(userEmail);
        $('#modalNewPassword').val('');
        $('#modalNewPassword').attr('type', 'password');
        $('#togglePasswordIcon').removeClass('fa-eye-slash').addClass('fa-eye');
        $('#modalSendEmail').prop('checked', false);

        const modalEl = document.getElementById('managePasswordModal');
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();
    });

    // Toggle password visibility
    $('#togglePasswordVisibility').on('click', function() {
        const $pw = $('#modalNewPassword');
        const $icon = $('#togglePasswordIcon');
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
        $('#togglePasswordIcon').removeClass('fa-eye').addClass('fa-eye-slash');
    });

    // Copy password to clipboard
    $('#btnCopyPassword').on('click', function() {
        const password = $('#modalNewPassword').val();
        if (!password) {
            Swal.fire({
                icon: 'warning',
                title: 'Empty Password',
                text: 'Please enter or generate a password first.',
                timer: 2000,
                showConfirmButton: false
            });
            return;
        }
        navigator.clipboard.writeText(password).then(() => {
            Swal.fire({
                icon: 'success',
                title: 'Copied!',
                text: 'Password copied to clipboard: ' + password,
                timer: 2000,
                showConfirmButton: false
            });
        }).catch(() => {
            Swal.fire({
                icon: 'info',
                title: 'Password',
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
            Swal.fire('Error', 'Password must be at least 6 characters.', 'warning');
            return;
        }

        let url = '{{ route("admin.users.change-password", ":id") }}';
        url = url.replace(':id', userId);

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
                const modalEl = document.getElementById('managePasswordModal');
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();

                Swal.fire({
                    icon: 'success',
                    title: 'Password Updated!',
                    html: `<p>${response.message}</p><p class="mt-2 mb-0"><strong>New Password:</strong> <code style="font-size: 16px; color: #dc2626;">${password}</code></p>`,
                    confirmButtonText: 'OK'
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
            always: function() {
                $btn.prop('disabled', false).html('<i class="fa-solid fa-floppy-disk me-1"></i> Save Password');
            }
        });
    });
});
</script>
