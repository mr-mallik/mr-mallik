<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>LinkedIn Reachout Messages</title>
	<meta name="description" content="Professional LinkedIn outreach message templates to help you connect with potential employers and hiring managers. Customize and copy messages easily.">
	<meta name="keywords" content="LinkedIn outreach, job search templates, professional messages, hiring manager contact, job application messages, LinkedIn networking, customizable templates">
	<meta name="author" content="Gulger Mallik">

	<!-- Open Graph Meta Tags -->
	<meta property="og:title" content="LinkedIn Reachout Messages">
	<meta property="og:description" content="Professional LinkedIn outreach message templates to help you connect with potential employers and hiring managers. Customize and copy messages easily.">
	<meta property="og:image" content="https://mrmallik.com/assets/images/gulger-mallik@1x1.jpg">
	<meta property="og:url" content="https://mrmallik.com/tools/reachout.php">
	<meta property="og:type" content="website">
	<!-- Twitter Card Meta Tags -->
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:title" content="LinkedIn Reachout Messages">
	<meta name="twitter:description" content="Professional LinkedIn outreach message templates to help you connect with potential employers and hiring managers. Customize and copy messages easily.">
	<meta name="twitter:image" content="https://mrmallik.com/assets/images/gulger-mallik@1x1.jpg">
	<link rel="icon" href="https://mrmallik.com/assets/images/gulger-mallik@1x1.jpg" type="image/x-icon">

	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap">
	<script src="https://cdn.tailwindcss.com"></script>
	<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.11/clipboard.min.js"></script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
	<style>
		.template-card {
			transition: all 0.3s ease;
		}
		.template-card:hover {
			transform: translateY(-2px);
		}
		.fade-in {
			animation: fadeIn 0.5s ease-in;
		}
		@keyframes fadeIn {
			from { opacity: 0; transform: translateY(10px); }
			to { opacity: 1; transform: translateY(0); }
		}
		.copy-notification {
			position: fixed;
			top: 20px;
			right: 20px;
			z-index: 1000;
			transform: translateX(400px);
			transition: transform 0.3s ease;
		}
		.copy-notification.show {
			transform: translateX(0);
		}
		
		/* Dark mode styles */
		.dark {
			background-color: #111827;
			color: #f9fafb;
		}
		.dark .bg-gray-50 {
			background-color: #1f2937;
		}
		.dark .bg-white {
			background-color: #374151;
		}
		.dark .text-gray-800 {
			color: #f3f4f6;
		}
		.dark .text-gray-700 {
			color: #d1d5db;
		}
		.dark .text-gray-600 {
			color: #9ca3af;
		}
		.dark .text-gray-500 {
			color: #6b7280;
		}
		.dark .text-gray-400 {
			color: #9ca3af;
		}
		.dark .border-gray-300 {
			border-color: #4b5563;
		}
		.dark .bg-gray-100 {
			background-color: #4b5563;
		}
		.dark input, .dark .bg-gray-50 {
			background-color: #4b5563;
			color: #f9fafb;
		}
		.dark input::placeholder {
			color: #9ca3af;
		}
		.dark .shadow-lg {
			box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.1);
		}
		.dark .bg-gray-200 {
			background-color: #4b5563;
			color: #f9fafb;
		}
		.dark .bg-gray-200:hover {
			background-color: #6b7280;
		}
		.dark .border-l-4 {
			border-left-color: #3b82f6;
		}
		
		/* Theme toggle button styles */
		.theme-toggle {
			position: relative;
			width: 60px;
			height: 30px;
			background: #e5e7eb;
			border-radius: 15px;
			cursor: pointer;
			transition: all 0.3s ease;
			border: none;
			outline: none;
		}
		.dark .theme-toggle {
			background: #374151;
		}
		.theme-toggle::before {
			content: '';
			position: absolute;
			top: 3px;
			left: 3px;
			width: 24px;
			height: 24px;
			background: white;
			border-radius: 50%;
			transition: all 0.3s ease;
			box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
		}
		.dark .theme-toggle::before {
			transform: translateX(30px);
			background: #fbbf24;
		}
		.theme-toggle i {
			position: absolute;
			top: 50%;
			transform: translateY(-50%);
			font-size: 12px;
			transition: all 0.3s ease;
		}
		.theme-toggle .fa-sun {
			right: 8px;
			color: #fbbf24;
			opacity: 1;
		}
		.theme-toggle .fa-moon {
			left: 8px;
			color: #6b7280;
			opacity: 0;
		}
		.dark .theme-toggle .fa-sun {
			opacity: 0;
		}
		.dark .theme-toggle .fa-moon {
			opacity: 1;
			color: #e5e7eb;
		}
	</style>
</head>
<body class="dark:bg-gray-800 bg-gray-50 min-h-screen py-8">
<?php
$templates = [];

$templates[] = [
	'title'=>"Friendly & casual",
	'text'=>"Hey [Name], hope you're doing well! I'm currently looking for new roles in [RoleSkills]. If you hear of any openings or can introduce me to someone hiring, I'd really appreciate it."
];

$templates[] = [
	'title'=>"Polite & professional",
	'text'=>"Hi [Name], I'm exploring new opportunities in [RoleSkills] and wanted to ask if there are any openings or referrals you could recommend at your company. Thanks in advance for any leads!"
];

$templates[] = [
	'title'=>"Direct & confident",
	'text'=>"Hey [Name], I'm looking for my next role in [RoleSkills]. If your company or someone in your network is hiring, could you point me their way? Appreciate it!"
];

$templates[] = [
	'title'=>"Value-focused approach",
	'text'=>"Hi [Name], I've been following [Company]'s work and I'm impressed by your team's achievements. I'm a professional with experience in [RoleSkills], and I'd love to contribute to your mission. Are there any opportunities to chat about potential openings?"
];

$templates[] = [
	'title'=>"Mutual connection referral",
	'text'=>"Hi [Name], I hope this message finds you well. [MutualConnection] mentioned you might be a great person to connect with regarding opportunities in [RoleSkills]. I'm actively seeking new challenges and would appreciate any insights you might have about the current market or openings at [Company]."
];

$templates[] = [
	'title'=>"Industry-specific interest",
	'text'=>"Hello [Name], I'm reaching out because I'm particularly interested in working in the [Industry] space, and I see you're doing great work at [Company]. As a professional with experience in [RoleSkills], I'd love to learn more about potential opportunities in your organization."
];

$templates[] = [
	'title'=>"Follow-up after event/post",
	'text'=>"Hi [Name], I really enjoyed your recent post about [Topic] - it resonated with my own experience in [RoleSkills]. I'm currently exploring new opportunities and wondered if you might have insights about openings at [Company] or in your network."
];

$templates[] = [
	'title'=>"Career transition angle",
	'text'=>"Hello [Name], I'm at an exciting point in my career where I'm looking to take on new challenges in [RoleSkills]. Your background at [Company] caught my attention, and I'd appreciate any advice about opportunities that might be a good fit for someone with experience in [RoleSkills]."
];

$templates[] = [
	'title'=>"Specific role inquiry",
	'text'=>"Hi [Name], I noticed [Company] recently posted about expanding their team. With my background in [RoleSkills], I believe I could make a strong contribution. Would you be open to a brief conversation about the role and company culture?"
];

$templates[] = [
	'title'=>"Warm and personal",
	'text'=>"Hi [Name], I hope you're having a great week! I'm currently in the job market for [RoleSkills] roles and thought you might be a wonderful person to connect with. If you know of any opportunities or could point me toward the right people, I'd be incredibly grateful."
];

$templates[] = [
	'title'=>"Brief and to-the-point",
	'text'=>"Hi [Name], I'm a professional in [RoleSkills] seeking new opportunities. Any chance your team or network has openings? Would love to connect. Thanks!"
];

$templates[] = [
	'title'=>"Hiring manager direct approach",
	'text'=>"Hello [Name], I saw your post about hiring for the team at [Company]. I'm a professional with strong experience in [RoleSkills], and I'm very interested in contributing to your team's success. Would you be open to discussing how my skills might align with your current needs?"
];

$templates[] = [
	'title'=>"Alumni/School connection",
	'text'=>"Hi [Name], I see we both studied at [School]! I'm currently looking for new opportunities in [RoleSkills] and thought it would be great to connect with a fellow [School] grad. Are there any openings at [Company] or in your network that might be a good fit?"
];

$templates[] = [
	'title'=>"Recruiter-focused message",
	'text'=>"Hi [Name], I'm actively seeking new opportunities in [RoleSkills] and would love to learn about positions you're currently working on. I have experience in [RoleSkills] and would appreciate the chance to discuss how I might fit with your current client needs."
];
?>

	<div class="container mx-auto px-4 max-w-6xl">
		<!-- Header -->
		<div class="text-center mb-8 relative">
			<!-- Theme Toggle Button -->
			<div class="absolute top-0 right-0 flex items-center gap-2">
				<div class="text-xs text-gray-500 hidden md:block" title="Keyboard shortcuts: Ctrl+Shift+D (toggle theme), Ctrl+Shift+R (reset theme)">
					<i class="fas fa-keyboard mr-1"></i>
					<span class="hidden lg:inline">Ctrl+Shift+D/R</span>
				</div>
				<button id="themeToggle" class="theme-toggle" title="Toggle dark/light mode (Ctrl+Shift+D)">
					<i class="fas fa-sun"></i>
					<i class="fas fa-moon"></i>
				</button>
			</div>
			
			<h1 class="text-4xl font-bold text-gray-800 dark:text-gray-200 mb-2">LinkedIn Outreach Templates</h1>
			<p class="text-gray-600 dark:text-gray-400">Professional templates to help you connect with potential employers and hiring managers</p>
		</div>

		<!-- Form Section -->
		<div class="bg-white rounded-lg shadow-lg p-6 mb-8">
			<h2 class="text-2xl font-semibold text-gray-800 mb-4">
				<i class="fas fa-edit text-blue-500 mr-2"></i>Customize Your Templates
			</h2>
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
				<div class="relative">
					<label for="person_name" class="block text-sm font-medium text-gray-700 mb-1">Person's Name</label>
					<input type="text" name="person_name" id="person_name" 
						   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
						   autocomplete="off" placeholder="e.g., John Smith" />
					<i class="fas fa-user absolute right-3 top-9 text-gray-400"></i>
				</div>
				<div class="relative">
					<label for="company" class="block text-sm font-medium text-gray-700 mb-1">Company Name</label>
					<input type="text" name="company" id="company" 
						   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
						   autocomplete="off" placeholder="e.g., Google" />
					<i class="fas fa-building absolute right-3 top-9 text-gray-400"></i>
				</div>
				<div class="relative">
					<label for="role_skills" class="block text-sm font-medium text-gray-700 mb-1">Role/Skills</label>
					<input type="text" name="role_skills" id="role_skills" 
						   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
						   autocomplete="off" placeholder="e.g., Data Science, Marketing, UX Design" />
					<i class="fas fa-briefcase absolute right-3 top-9 text-gray-400"></i>
				</div>
				<div class="relative">
					<label for="mutual_connection" class="block text-sm font-medium text-gray-700 mb-1">Mutual Connection</label>
					<input type="text" name="mutual_connection" id="mutual_connection" 
						   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
						   autocomplete="off" placeholder="e.g., Jane Doe" />
					<i class="fas fa-users absolute right-3 top-9 text-gray-400"></i>
				</div>
				<div class="relative">
					<label for="school" class="block text-sm font-medium text-gray-700 mb-1">School/University</label>
					<input type="text" name="school" id="school" 
						   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
						   autocomplete="off" placeholder="e.g., MIT" />
					<i class="fas fa-graduation-cap absolute right-3 top-9 text-gray-400"></i>
				</div>
			</div>
			<div class="mt-4 flex flex-wrap gap-2 items-center">
				<button id="clearAll" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
					<i class="fas fa-eraser mr-1"></i>Clear All
				</button>
				<button id="copyAllBtn" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
					<i class="fas fa-copy mr-1"></i>Copy All Templates
				</button>
				<button id="clearStorageBtn" class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors">
					<i class="fas fa-database mr-1"></i>Clear Saved Data
				</button>
				<button id="resetThemeBtn" class="px-4 py-2 bg-purple-500 text-white rounded-lg hover:bg-purple-600 transition-colors" title="Reset to system preference">
					<i class="fas fa-palette mr-1"></i>Reset Theme
				</button>
				<div class="text-sm text-gray-500 hidden" id="storageIndicator">
					<i class="fas fa-save mr-1 text-green-500"></i>Data auto-saved
				</div>
				<div class="text-sm text-gray-500" id="themeIndicator">
					<i class="fas fa-palette mr-1"></i><span id="currentTheme">Auto</span>
				</div>
				<div class="ml-auto">
					<label class="inline-flex items-center">
						<input type="checkbox" id="showOnlyFilled" class="form-checkbox h-4 w-4 text-blue-600">
						<span class="ml-2 text-sm text-gray-700">Show only relevant templates</span>
					</label>
				</div>
			</div>
		</div>

		<!-- Templates Section -->
		<div class="grid grid-cols-1 lg:grid-cols-2 gap-6" id="templates">
			<?php foreach($templates as $_i => $_template): ?>
				<div id="template_<?= $_i; ?>" class="template-card bg-white rounded-lg shadow-lg p-6 fade-in" 
					 data-template-type="<?= strtolower(str_replace(' ', '-', $_template['title'])); ?>">
					<div class="flex justify-between items-start mb-4">
						<h3 class="text-xl font-semibold text-gray-800"><?= $_template['title']; ?></h3>
						<div class="flex space-x-2">
							<button class="copy-btn bg-blue-500 text-white px-3 py-1 rounded-md text-sm hover:bg-blue-600 transition-colors" 
									data-template-id="<?= $_i; ?>" title="Copy to clipboard">
								<i class="fas fa-copy"></i>
							</button>
							<button class="favorite-btn text-gray-400 hover:text-red-500 transition-colors" 
									data-template-id="<?= $_i; ?>" title="Add to favorites">
								<i class="far fa-heart"></i>
							</button>
						</div>
					</div>
					<div class="bg-gray-50 p-4 rounded-lg border-l-4 border-blue-500">
						<p class="replace_name text-gray-700 leading-relaxed" 
						   data-original="<?= htmlspecialchars($_template['text']); ?>"
						   data-template-id="<?= $_i; ?>">
							<?= $_template['text']; ?>
						</p>
					</div>
					<div class="mt-3 flex justify-between items-center text-sm text-gray-500">
						<span class="character-count">Characters: <span class="count">0</span></span>
						<span class="template-tags">
							<?php
							$tags = [];
							if (strpos($_template['text'], '[Company]') !== false) $tags[] = 'Company';
							if (strpos($_template['text'], '[MutualConnection]') !== false) $tags[] = 'Connection';
							if (strpos($_template['text'], '[School]') !== false) $tags[] = 'Alumni';
							if (strpos($_template['text'], '[RoleSkills]') !== false) $tags[] = 'Role/Skills';
							if (!empty($tags)) {
								echo '<span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs mr-1">' . implode('</span> <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs mr-1">', $tags) . '</span>';
							}
							?>
						</span>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	<!-- Copy Notification -->
	<div id="copyNotification" class="copy-notification bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
		<i class="fas fa-check-circle mr-2"></i>
		<span>Copied to clipboard!</span>
	</div>

	<!-- Footer -->
	<footer class="mt-12 text-center text-gray-500">
		<p>&copy; 2025 LinkedIn Outreach Templates. Made with ❤️ for job seekers.</p>
		<p class="text-sm">Developer by <a href="https://github.com/mr-mallik" target="_blank" class="text-blue-500 hover:underline">Gulger Mallik</a></p>
		<p class="text-xs mt-2">
			💡 <strong>Pro tips:</strong> Use <kbd class="px-1 py-0.5 bg-gray-200 dark:bg-gray-600 rounded text-xs">Ctrl+Shift+D</kbd> to toggle theme, 
			<kbd class="px-1 py-0.5 bg-gray-200 dark:bg-gray-600 rounded text-xs">Ctrl+Shift+R</kbd> to reset to system preference
		</p>
	</footer>

</body>

<script>
$(document).ready(function() {
	// Initialize clipboard.js
	const clipboard = new ClipboardJS('.copy-btn', {
		text: function(trigger) {
			const templateId = trigger.getAttribute('data-template-id');
			const textElement = document.querySelector(`[data-template-id="${templateId}"].replace_name`);
			return textElement.textContent;
		}
	});

	// Copy notification
	clipboard.on('success', function(e) {
		showNotification('Copied to clipboard!');
		e.clearSelection();
	});

	clipboard.on('error', function(e) {
		showNotification('Failed to copy. Please try again.', 'error');
	});

	// Save input values to localStorage
	function saveInputsToStorage() {
		const inputData = {
			person_name: $('#person_name').val(),
			company: $('#company').val(),
			mutual_connection: $('#mutual_connection').val(),
			school: $('#school').val(),
			role_skills: $('#role_skills').val()
		};
		localStorage.setItem('linkedin_outreach_inputs', JSON.stringify(inputData));
		
		// Show storage indicator if any data exists
		const hasData = Object.values(inputData).some(value => value && value.trim() !== '');
		if (hasData) {
			$('#storageIndicator').removeClass('hidden');
			setTimeout(() => $('#storageIndicator').addClass('hidden'), 2000);
		}
	}

	// Load input values from localStorage
	function loadInputsFromStorage() {
		const savedData = localStorage.getItem('linkedin_outreach_inputs');
		if (savedData) {
			try {
				const inputData = JSON.parse(savedData);
				$('#person_name').val(inputData.person_name || '');
				$('#company').val(inputData.company || '');
				$('#mutual_connection').val(inputData.mutual_connection || '');
				$('#school').val(inputData.school || '');
				$('#role_skills').val(inputData.role_skills || '');
			} catch (e) {
				console.log('Error loading saved data:', e);
			}
		}
	}

	// Clear inputs from localStorage
	function clearInputsFromStorage() {
		localStorage.removeItem('linkedin_outreach_inputs');
	}

	// Update templates on input change
	function updateTemplates() {
		const name = $('#person_name').val();
		const company = $('#company').val();
		const mutualConnection = $('#mutual_connection').val();
		const school = $('#school').val();
		const roleSkills = $('#role_skills').val();

		$('.replace_name').each(function() {
			const originalText = $(this).data('original');
			let updatedText = originalText
				.replace(/\[Name\]/g, name)
				.replace(/\[Company\]/g, company)
				.replace(/\[MutualConnection\]/g, mutualConnection)
				.replace(/\[School\]/g, school)
				.replace(/\[RoleSkills\]/g, roleSkills);

			$(this).text(updatedText);
			
			// Update character count
			const characterCount = updatedText.length;
			$(this).closest('.template-card').find('.count').text(characterCount);
			
			// Add color coding for LinkedIn message length
			const countElement = $(this).closest('.template-card').find('.character-count');
			if (characterCount > 300) {
				countElement.removeClass('text-gray-500 text-green-600').addClass('text-red-600');
			} else if (characterCount > 200) {
				countElement.removeClass('text-gray-500 text-red-600').addClass('text-orange-500');
			} else {
				countElement.removeClass('text-red-600 text-orange-500').addClass('text-green-600');
			}
		});

		// Save inputs to localStorage whenever templates are updated
		saveInputsToStorage();

		// Filter templates if "show only relevant" is checked
		filterTemplates();
	}

	// Bind input events
	$('#person_name, #company, #mutual_connection, #school, #role_skills').on('input', updateTemplates);

	// Clear all inputs
	$('#clearAll').click(function() {
		$('#person_name, #company, #mutual_connection, #school, #role_skills').val('');
		clearInputsFromStorage();
		updateTemplates();
		showNotification('All fields cleared and data removed from storage!', 'success');
	});

	// Clear storage only (separate button)
	$('#clearStorageBtn').click(function() {
		if (confirm('Are you sure you want to clear all saved data including theme preferences? This cannot be undone.')) {
			clearInputsFromStorage();
			localStorage.removeItem('linkedin-outreach-theme');
			// Clear favorites
			Object.keys(localStorage).forEach(key => {
				if (key.startsWith('favorite_')) {
					localStorage.removeItem(key);
				}
			});
			// Reset theme to system default
			resetTheme();
			// Reset favorites UI
			$('.favorite-btn i').removeClass('fas text-red-500').addClass('far');
			showNotification('All saved data cleared from storage!', 'success');
			$('#storageIndicator').addClass('hidden');
		}
	});

	// Copy all templates
	$('#copyAllBtn').click(function() {
		let allTemplates = '';
		$('.replace_name').each(function() {
			const title = $(this).closest('.template-card').find('h3').text();
			const text = $(this).text();
			allTemplates += `${title}:\n${text}\n\n`;
		});
		
		navigator.clipboard.writeText(allTemplates).then(function() {
			showNotification('All templates copied to clipboard!');
		});
	});

	// Favorite functionality
	$('.favorite-btn').click(function() {
		const icon = $(this).find('i');
		const templateId = $(this).data('template-id');
		
		if (icon.hasClass('far')) {
			icon.removeClass('far').addClass('fas text-red-500');
			localStorage.setItem(`favorite_${templateId}`, 'true');
		} else {
			icon.removeClass('fas text-red-500').addClass('far');
			localStorage.removeItem(`favorite_${templateId}`);
		}
	});

	// Load favorites from localStorage
	$('.favorite-btn').each(function() {
		const templateId = $(this).data('template-id');
		if (localStorage.getItem(`favorite_${templateId}`) === 'true') {
			$(this).find('i').removeClass('far').addClass('fas text-red-500');
		}
	});

	// Filter templates based on relevance
	$('#showOnlyFilled').change(filterTemplates);

	function filterTemplates() {
		if (!$('#showOnlyFilled').is(':checked')) {
			$('.template-card').show();
			return;
		}

		const name = $('#person_name').val();
		const company = $('#company').val();
		const mutualConnection = $('#mutual_connection').val();
		const school = $('#school').val();
		const roleSkills = $('#role_skills').val();

		$('.template-card').each(function() {
			const originalText = $(this).find('.replace_name').data('original');
			let shouldShow = !name || originalText.includes('[Name]');
			
			if (company && originalText.includes('[Company]')) shouldShow = true;
			if (mutualConnection && originalText.includes('[MutualConnection]')) shouldShow = true;
			if (school && originalText.includes('[School]')) shouldShow = true;
			if (roleSkills && originalText.includes('[RoleSkills]')) shouldShow = true;

			// Always show if no specific placeholders or if name is filled
			if (!originalText.includes('[Company]') && !originalText.includes('[MutualConnection]') && !originalText.includes('[School]') && !originalText.includes('[RoleSkills]')) {
				shouldShow = true;
			}

			$(this).toggle(shouldShow);
		});
	}

	function showNotification(message, type = 'success') {
		const notification = $('#copyNotification');
		const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
		
		notification.removeClass('bg-green-500 bg-red-500').addClass(bgColor);
		notification.find('span').text(message);
		notification.addClass('show');
		
		setTimeout(() => {
			notification.removeClass('show');
		}, 3000);
	}

	// Load saved inputs on page load
	loadInputsFromStorage();

	// Initialize character counts
	updateTemplates();

	// Add smooth scroll for better UX
	$('html').css('scroll-behavior', 'smooth');

	// Add loading animation for template cards
	$('.template-card').each(function(index) {
		$(this).css('animation-delay', `${index * 0.1}s`);
	});

	// Theme management functionality
	function updateThemeIndicator() {
		const savedTheme = localStorage.getItem('linkedin-outreach-theme');
		const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
		
		if (!savedTheme) {
			$('#currentTheme').text(`Auto (${systemPrefersDark ? 'Dark' : 'Light'})`);
		} else {
			$('#currentTheme').text(savedTheme.charAt(0).toUpperCase() + savedTheme.slice(1));
		}
	}

	function initializeTheme() {
		// Check for saved theme preference or default to system preference
		const savedTheme = localStorage.getItem('linkedin-outreach-theme');
		const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
		
		let isDark = false;
		
		if (savedTheme) {
			isDark = savedTheme === 'dark';
		} else {
			isDark = systemPrefersDark;
		}
		
		// Apply theme
		if (isDark) {
			$('body').addClass('dark');
		} else {
			$('body').removeClass('dark');
		}
		
		// Update indicator
		updateThemeIndicator();
		
		return isDark;
	}

	function toggleTheme() {
		const isDark = $('body').hasClass('dark');
		
		if (isDark) {
			$('body').removeClass('dark');
			localStorage.setItem('linkedin-outreach-theme', 'light');
			showNotification('Switched to light mode', 'success');
		} else {
			$('body').addClass('dark');
			localStorage.setItem('linkedin-outreach-theme', 'dark');
			showNotification('Switched to dark mode', 'success');
		}
		
		// Update indicator
		updateThemeIndicator();
	}

	function resetTheme() {
		localStorage.removeItem('linkedin-outreach-theme');
		const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
		
		if (systemPrefersDark) {
			$('body').addClass('dark');
		} else {
			$('body').removeClass('dark');
		}
		
		updateThemeIndicator();
		showNotification('Theme reset to system preference', 'success');
	}

	// Theme toggle button click handler
	$('#themeToggle').click(function() {
		toggleTheme();
	});

	// Reset theme button click handler
	$('#resetThemeBtn').click(function() {
		resetTheme();
	});

	// Listen for system theme changes
	window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function(e) {
		// Only auto-switch if user hasn't manually set a preference
		if (!localStorage.getItem('linkedin-outreach-theme')) {
			if (e.matches) {
				$('body').addClass('dark');
			} else {
				$('body').removeClass('dark');
			}
			updateThemeIndicator();
		}
	});

	// Initialize theme on page load
	initializeTheme();

	// Keyboard shortcuts
	$(document).keydown(function(e) {
		// Ctrl/Cmd + Shift + D for theme toggle
		if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === 'D') {
			e.preventDefault();
			toggleTheme();
		}
		// Ctrl/Cmd + Shift + R for reset theme
		if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === 'R') {
			e.preventDefault();
			resetTheme();
		}
	});

	// Show notification if data was loaded from storage
	setTimeout(function() {
		const savedData = localStorage.getItem('linkedin_outreach_inputs');
		if (savedData) {
			const inputData = JSON.parse(savedData);
			const hasData = Object.values(inputData).some(value => value && value.trim() !== '');
			if (hasData) {
				showNotification('Previous data restored from storage!', 'success');
				$('#storageIndicator').removeClass('hidden');
				setTimeout(() => $('#storageIndicator').addClass('hidden'), 3000);
			}
		}
	}, 500);

	// Update storage indicator visibility based on stored data
	function updateStorageIndicator() {
		const savedData = localStorage.getItem('linkedin_outreach_inputs');
		if (savedData) {
			const inputData = JSON.parse(savedData);
			const hasData = Object.values(inputData).some(value => value && value.trim() !== '');
			$('#clearStorageBtn').toggle(hasData);
		} else {
			$('#clearStorageBtn').hide();
		}
	}

	// Initial storage indicator update
	updateStorageIndicator();
});
</script>
</html>