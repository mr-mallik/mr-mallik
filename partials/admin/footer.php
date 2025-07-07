    </div> <!-- End of main content -->
</div> <!-- End of sidebar wrapper -->

<script>
// Initialize AOS
AOS.init({
    duration: 800,
    once: true
});

// Alert auto-hide
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            alert.style.opacity = '0';
            setTimeout(function() {
                alert.remove();
            }, 300);
        }, 5000);
    });
});

// Form validation
function validateForm(form) {
    const requiredFields = form.querySelectorAll('[required]');
    let isValid = true;
    
    requiredFields.forEach(function(field) {
        if (!field.value.trim()) {
            field.classList.add('border-red-500');
            isValid = false;
        } else {
            field.classList.remove('border-red-500');
        }
    });
    
    return isValid;
}

// File upload preview
function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById(previewId).innerHTML = 
                `<img src="${e.target.result}" alt="Preview" class="max-w-full h-auto rounded-lg shadow-md">`;
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