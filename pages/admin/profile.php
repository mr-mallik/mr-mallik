<?php
require_once __DIR__ . '/../../includes/admin-common.php';
checkAdminAuth();

// Get current user data
$userId = $_SESSION['admin_user']['id'] ?? null;
if (!$userId) {
    redirect("/admin/login", "error", "Invalid session. Please login again.");
}

// Get user profile data
$stmt = $CONN->prepare("SELECT * FROM profile WHERE id = ? LIMIT 1");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    redirect("/admin/login", "error", "User not found. Please login again.");
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    switch ($action) {
        case 'update_profile':
            $firstName = sanitizeInput($_POST['first_name'] ?? '');
            $lastName = sanitizeInput($_POST['last_name'] ?? '');
            $email = sanitizeInput($_POST['email'] ?? '');
            $phone = sanitizeInput($_POST['phone'] ?? '');
            $designation = sanitizeInput($_POST['designation'] ?? '');
            $aboutMe = sanitizeInput($_POST['about_me'] ?? '');
            
            // Validate required fields
            if (empty($firstName) || empty($email)) {
                redirect("/admin/profile", "error", "First name and email are required.");
            }
            
            // Validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                redirect("/admin/profile", "error", "Please enter a valid email address.");
            }
            
            // Check if email is already taken by another user
            $stmt = $CONN->prepare("SELECT COUNT(*) as count FROM profile WHERE email = ? AND id != ?");
            $stmt->execute([$email, $userId]);
            $emailExists = $stmt->fetch(PDO::FETCH_ASSOC)['count'] > 0;
            
            if ($emailExists) {
                redirect("/admin/profile", "error", "Email address is already in use.");
            }
            
            try {
                $sql = "UPDATE profile SET first_name = ?, last_name = ?, email = ?, phone = ?, designation = ?, about_me = ? WHERE id = ?";
                $stmt = $CONN->prepare($sql);
                
                if ($stmt->execute([$firstName, $lastName, $email, $phone, $designation, $aboutMe])) {
                    // Update session data
                    $_SESSION['admin_user']['first_name'] = $firstName;
                    $_SESSION['admin_user']['last_name'] = $lastName;
                    $_SESSION['admin_user']['email'] = $email;
                    $_SESSION['admin_user']['phone'] = $phone;
                    $_SESSION['admin_user']['designation'] = $designation;
                    $_SESSION['admin_user']['about_me'] = $aboutMe;
                    
                    redirect("/admin/profile", "success", "Profile updated successfully!");
                } else {
                    redirect("/admin/profile", "error", "Failed to update profile.");
                }
            } catch (Exception $e) {
                redirect("/admin/profile", "error", "Error: " . $e->getMessage());
            }
            break;
            
        case 'change_password':
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            
            // Validate required fields
            if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
                redirect("/admin/profile", "error", "All password fields are required.");
            }
            
            // Verify current password
            if (!verifyCurrentPassword($userId, $currentPassword)) {
                redirect("/admin/profile", "error", "Current password is incorrect.");
            }
            
            // Check if new passwords match
            if ($newPassword !== $confirmPassword) {
                redirect("/admin/profile", "error", "New passwords do not match.");
            }
            
            // Validate new password strength
            $passwordErrors = validatePassword($newPassword);
            if (!empty($passwordErrors)) {
                redirect("/admin/profile", "error", "Password requirements: " . implode(", ", $passwordErrors));
            }
            
            try {
                if (updateUserPassword($userId, $newPassword)) {
                    redirect("/admin/profile", "success", "Password changed successfully!");
                } else {
                    redirect("/admin/profile", "error", "Failed to change password.");
                }
            } catch (Exception $e) {
                redirect("/admin/profile", "error", "Error: " . $e->getMessage());
            }
            break;
    }
}

require_once __DIR__ . '/../../partials/admin/header.php';
require_once __DIR__ . '/../../partials/admin/side-nav.php';
?>

<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Profile Settings</h2>
            <div class="flex items-center space-x-4">
                <a href="<?php echo APP_URL; ?>/admin/profile" 
                   class="text-blue-600 hover:text-blue-800">
                    <i class="fas fa-user mr-2"></i>Profile
                </a>
                <a href="<?php echo APP_URL; ?>/admin" 
                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
                </a>
            </div>
    </div>
    
    <?php echo show_alert_message('success'); ?>
    <?php echo show_alert_message('error'); ?>
    
    <!-- Profile Information -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Profile Information</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">Update your account's profile information and email address.</p>
        </div>
        
        <form method="POST" class="p-6 space-y-6">
            <input type="hidden" name="action" value="update_profile">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">First Name</label>
                    <input type="text" name="first_name" id="first_name" required 
                           value="<?php echo htmlspecialchars($user['first_name'] ?? ''); ?>"
                           class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Last Name</label>
                    <input type="text" name="last_name" id="last_name" 
                           value="<?php echo htmlspecialchars($user['last_name'] ?? ''); ?>"
                           class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Address</label>
                    <input type="email" name="email" id="email" required 
                           value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>"
                           class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone Number</label>
                    <input type="tel" name="phone" id="phone" 
                           value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>"
                           class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
            
            <div>
                <label for="designation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Designation</label>
                <input type="text" name="designation" id="designation" 
                       value="<?php echo htmlspecialchars($user['designation'] ?? ''); ?>"
                       placeholder="e.g., Software Engineer, Project Manager"
                       class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div>
                <label for="about_me" class="block text-sm font-medium text-gray-700 dark:text-gray-300">About Me</label>
                <textarea name="about_me" id="about_me" rows="4" 
                          placeholder="Tell us about yourself..."
                          class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"><?php echo htmlspecialchars($user['about_me'] ?? ''); ?></textarea>
            </div>
            
            <div class="flex justify-end">
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-save mr-2"></i>Update Profile
                </button>
            </div>
        </form>
    </div>
    
    <!-- Password Change -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Change Password</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">Ensure your account is using a long, random password to stay secure.</p>
        </div>
        
        <form method="POST" class="p-6 space-y-6">
            <input type="hidden" name="action" value="change_password">
            
            <div>
                <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Current Password</label>
                <input type="password" name="current_password" id="current_password" required 
                       class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="new_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">New Password</label>
                    <input type="password" name="new_password" id="new_password" required 
                           class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                        <p>Password must contain:</p>
                        <ul class="list-disc list-inside space-y-1">
                            <li>At least 8 characters</li>
                            <li>One uppercase letter</li>
                            <li>One lowercase letter</li>
                            <li>One number</li>
                        </ul>
                    </div>
                </div>
                
                <div>
                    <label for="confirm_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirm New Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" required 
                           class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
            
            <div class="flex justify-end">
                <button type="submit" 
                        onclick="return confirm('Are you sure you want to change your password? You will need to login again with the new password.')"
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                    <i class="fas fa-key mr-2"></i>Change Password
                </button>
            </div>
        </form>
    </div>
    
    <!-- Account Information -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Account Information</h3>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">User ID</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white"><?php echo $user['id']; ?></p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Full Name</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">
                        <?php echo trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')); ?>
                    </p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Current Email</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">
                        <?php echo $user['email'] ?? 'N/A'; ?>
                    </p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Administrator
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Password strength indicator
document.getElementById('new_password').addEventListener('input', function() {
    const password = this.value;
    const requirements = {
        length: password.length >= 8,
        uppercase: /[A-Z]/.test(password),
        lowercase: /[a-z]/.test(password),
        number: /[0-9]/.test(password)
    };
    
    // You can add visual feedback here if needed
});

// Confirm password matching
document.getElementById('confirm_password').addEventListener('input', function() {
    const newPassword = document.getElementById('new_password').value;
    const confirmPassword = this.value;
    
    if (confirmPassword && newPassword !== confirmPassword) {
        this.setCustomValidity('Passwords do not match');
    } else {
        this.setCustomValidity('');
    }
});
</script>

<?php require_once __DIR__ . '/../../partials/admin/footer.php'; ?>
