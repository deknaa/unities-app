<!-- Toast Container -->
<div class="toast-container position-fixed top-0 end-0 p-4" style="z-index: 1050;">
    @if (session('success'))
        <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true" id="successToast">
            <div class="toast-header bg-success text-white">
                <i class="fas fa-check-circle me-2"></i>
                <strong class="me-auto">Success</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body bg-success text-white">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true" id="errorToast">
            <div class="toast-header bg-danger text-white">
                <i class="fas fa-exclamation-circle me-2"></i>
                <strong class="me-auto">Error</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body bg-danger text-white">
                {{ session('error') }}
            </div>
        </div>
    @endif
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize all toasts
        var toastElList = [].slice.call(document.querySelectorAll('.toast'));
        var toastList = toastElList.map(function(toastEl) {
            return new bootstrap.Toast(toastEl, {
                autohide: true,
                delay: 3000
            });
        });

        // Show toasts
        toastList.forEach(toast => toast.show());

        // Initialize all tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>