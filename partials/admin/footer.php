    </div> <!-- End of main content -->
    <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 mt-12 py-6">
        <div class="px-8 text-center text-sm text-gray-600 dark:text-gray-400">
            <p>&copy; <?php echo date('Y'); ?> Mr Mallik CMS. All rights reserved.</p>
        </div>
    </footer>
</div> <!-- End of sidebar wrapper -->

<script>
// Alert auto-hide with Material animation
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            alert.style.transform = 'translateX(400px)';
            alert.style.opacity = '0';
            setTimeout(function() {
                alert.remove();
            }, 300);
        }, 5000);
    });
});

// Form validation with Material styling
function validateForm(form) {
    const requiredFields = form.querySelectorAll('[required]');
    let isValid = true;
    
    requiredFields.forEach(function(field) {
        if (!field.value.trim()) {
            field.classList.add('border-red-500', 'ring-2', 'ring-red-200');
            isValid = false;
        } else {
            field.classList.remove('border-red-500', 'ring-2', 'ring-red-200');
        }
    });
    
    return isValid;
}

// File upload preview with Material card
function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById(previewId).innerHTML = 
                `<div class="material-card bg-white dark:bg-gray-700 p-4 rounded-xl shadow-lg">
                    <img src="${e.target.result}" alt="Preview" class="w-full h-auto rounded-lg">
                </div>`;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Confirm delete
function confirmDelete(url, itemName) {
    if (confirm(`Are you sure you want to delete "${itemName}"? This action cannot be undone.`)) {
        window.location.href = url;
    }
}

// Toggle visibility
function toggleVisibility(elementId) {
    const element = document.getElementById(elementId);
    if (element.style.display === 'none') {
        element.style.display = 'block';
    } else {
        element.style.display = 'none';
    }
}
</script>

</main>
</body>
</html>