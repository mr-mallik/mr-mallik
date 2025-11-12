<?php
/**
 * Cookie Consent Admin Dashboard
 * View consent logs and statistics
 */

require_once __DIR__ . '/../../includes/admin-common.php';
require_once __DIR__ . '/../../includes/cookies/CookieConsent.php';

checkAdminAuth();

$page_title = "Cookie Consent Management";
$cookieConsent = new CookieConsent();

// Handle log cleanup
if (isset($_POST['cleanup_logs'])) {
    $days = intval($_POST['retention_days']) ?: 365;
    $cookieConsent->cleanOldLogs($days);
    $success_message = "Old logs cleaned successfully. Kept logs from last {$days} days.";
}

// Get statistics and recent logs
$stats = $cookieConsent->getConsentStats();
$recentLogs = $cookieConsent->getRecentConsentLogs(20);

require_once __DIR__ . '/../../partials/admin/header.php';
require_once __DIR__ . '/../../partials/admin/side-nav.php';
?>

<?php if (isset($success_message)): ?>
    <div class="mb-4 p-4 bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded-lg">
        <div class="flex items-center">
            <i class="fas fa-check-circle text-green-600 dark:text-green-400 mr-2"></i>
            <span class="text-green-800 dark:text-green-200"><?= $success_message ?></span>
        </div>
    </div>
<?php endif; ?>

<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-chart-bar text-3xl text-blue-600"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Consents</dt>
                        <dd class="text-lg font-medium text-gray-900 dark:text-white"><?= number_format($stats['total']) ?></dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-3xl text-green-600"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Accept All</dt>
                        <dd class="text-lg font-medium text-gray-900 dark:text-white"><?= number_format($stats['accept_all']) ?></dd>
                        <dd class="text-xs text-gray-500 dark:text-gray-400"><?= $stats['total'] > 0 ? round(($stats['accept_all'] / $stats['total']) * 100, 1) : 0 ?>%</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-cog text-3xl text-orange-600"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Customize</dt>
                        <dd class="text-lg font-medium text-gray-900 dark:text-white"><?= number_format($stats['customize']) ?></dd>
                        <dd class="text-xs text-gray-500 dark:text-gray-400"><?= $stats['total'] > 0 ? round(($stats['customize'] / $stats['total']) * 100, 1) : 0 ?>%</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-times-circle text-3xl text-red-600"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Reject All</dt>
                        <dd class="text-lg font-medium text-gray-900 dark:text-white"><?= number_format($stats['reject_all']) ?></dd>
                        <dd class="text-xs text-gray-500 dark:text-gray-400"><?= $stats['total'] > 0 ? round(($stats['reject_all'] / $stats['total']) * 100, 1) : 0 ?>%</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Log Management -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Log Management</h3>
        </div>
        <div class="p-6">
            <form method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div>
                    <label for="retention_days" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Retention Period (days)
                    </label>
                    <input type="number" 
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" 
                           id="retention_days" 
                           name="retention_days" 
                           value="365" 
                           min="30" 
                           max="2555" 
                           required>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">GDPR recommends max 2 years (730 days)</p>
                </div>
                <div>
                    <button type="submit" 
                            name="cleanup_logs" 
                            class="w-full bg-orange-600 hover:bg-orange-700 text-white font-medium py-2 px-4 rounded-md transition-colors duration-200">
                        <i class="fas fa-broom mr-2"></i>Clean Old Logs
                    </button>
                </div>
                <div class="md:col-span-2">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        This will permanently delete logs older than the specified period.
                    </p>
                </div>
            </form>
        </div>
    </div>

    <!-- Recent Consent Logs -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex justify-content-between items-center">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Recent Consent Logs</h3>
                <button onclick="location.reload()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
        </div>
        <div class="p-6">
            <?php if (empty($recentLogs)): ?>
                <div class="text-center py-8">
                    <i class="fas fa-inbox text-4xl text-gray-400 mb-4"></i>
                    <p class="text-gray-500 dark:text-gray-400">No consent logs found.</p>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Timestamp
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Action
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    IP Address
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Browser
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Platform
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Consent Details
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Referer
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            <?php foreach ($recentLogs as $log): ?>
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">
                                        <?= date('M j, Y H:i:s', strtotime($log['timestamp'])) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php
                                        $actionColors = [
                                            'accept_all' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                            'accept_necessary' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                            'customize' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                            'reject_all' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
                                        ];
                                        $colorClass = $actionColors[$log['action']] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200';
                                        ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $colorClass ?>">
                                            <?= ucfirst(str_replace('_', ' ', $log['action'])) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900 dark:text-gray-300">
                                        <?= htmlspecialchars($log['ip_address']) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">
                                        <div class="flex items-center">
                                            <?= htmlspecialchars($log['browser_info']['browser'] ?? 'Unknown') ?>
                                            <?= htmlspecialchars($log['browser_info']['version'] ?? '') ?>
                                            <?php if ($log['browser_info']['is_mobile'] ?? false): ?>
                                                <i class="fas fa-mobile-alt text-blue-500 ml-2" title="Mobile"></i>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">
                                        <?= htmlspecialchars($log['browser_info']['platform'] ?? 'Unknown') ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">
                                        <?php if (isset($log['consent_data']['categories'])): ?>
                                            <div class="flex flex-wrap gap-1">
                                                <?php foreach ($log['consent_data']['categories'] as $category => $allowed): ?>
                                                    <?php if ($allowed): ?>
                                                        <span class="px-2 py-1 text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300 rounded">
                                                            <?= ucfirst($category) ?>
                                                        </span>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">
                                        <span title="<?= htmlspecialchars($log['referer']) ?>">
                                            <?= $log['referer'] === 'Direct' ? 'Direct' : (parse_url($log['referer'], PHP_URL_HOST) ?: 'Unknown') ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Quick Actions</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="<?= url('privacy-policy.php', false) ?>" target="_blank"
               class="flex items-center p-4 bg-blue-50 dark:bg-blue-900 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-800 transition-colors">
                <i class="fas fa-file-alt text-blue-600 mr-3"></i>
                <span class="text-blue-600 dark:text-blue-300 font-medium">View Privacy Policy</span>
            </a>
            <a href="<?= url('test-cookies.php', false) ?>" target="_blank"
               class="flex items-center p-4 bg-green-50 dark:bg-green-900 rounded-lg hover:bg-green-100 dark:hover:bg-green-800 transition-colors">
                <i class="fas fa-flask text-green-600 mr-3"></i>
                <span class="text-green-600 dark:text-green-300 font-medium">Test Cookie System</span>
            </a>
            <button onclick="exportLogs()" 
               class="flex items-center p-4 bg-purple-50 dark:bg-purple-900 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-800 transition-colors">
                <i class="fas fa-download text-purple-600 mr-3"></i>
                <span class="text-purple-600 dark:text-purple-300 font-medium">Export Logs</span>
            </button>
        </div>
    </div>
</div>

<script>
function exportLogs() {
    // Simple CSV export functionality
    const rows = [];
    const headers = ['Timestamp', 'Action', 'IP Address', 'Browser', 'Platform', 'Consent Categories', 'Referer'];
    rows.push(headers.join(','));
    
    <?php foreach ($recentLogs as $log): ?>
    const categories = <?= json_encode(array_keys(array_filter($log['consent_data']['categories'] ?? []))) ?>;
    rows.push([
        '<?= $log['timestamp'] ?>',
        '<?= $log['action'] ?>',
        '<?= $log['ip_address'] ?>',
        '<?= ($log['browser_info']['browser'] ?? 'Unknown') . ' ' . ($log['browser_info']['version'] ?? '') ?>',
        '<?= $log['browser_info']['platform'] ?? 'Unknown' ?>',
        categories.join(';'),
        '<?= str_replace(['"', "'"], '', $log['referer']) ?>'
    ].map(field => `"${field}"`).join(','));
    <?php endforeach; ?>
    
    const csv = rows.join('\n');
    const blob = new Blob([csv], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `cookie_consent_logs_${new Date().toISOString().split('T')[0]}.csv`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
}
</script>

<?php require_once __DIR__ . '/../../partials/admin/footer.php'; ?>
