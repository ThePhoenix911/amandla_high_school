/**
 * Amandla High School - Interactive Frontend Script
 */

document.addEventListener('DOMContentLoaded', () => {
    initPasswordToggle();
    initLiveTableSearch();
    initDestructiveActionConfirmations();
    initButtonRipples();
    initNavTabEffects();
    initDropdownToggle();
    initThemeToggle();
});

/**
 * 1. Password Visibility Toggle
 */
function initPasswordToggle() {
    const eyeTags = document.querySelectorAll('form fieldset div#password_eye i, .password_eye i, .fa-eye-slash, .fa-eye');
    const passwordInputs = document.querySelectorAll("input[type='password'], input[name*='password']");

    if (!eyeTags.length || !passwordInputs.length) return;

    eyeTags.forEach(eyeTag => {
        eyeTag.setAttribute('role', 'button');
        eyeTag.setAttribute('aria-label', 'Toggle password visibility');
        eyeTag.setAttribute('tabindex', '0');

        const toggleVisibility = () => {
            const isCurrentlyPassword = passwordInputs[0].type === 'password';

            passwordInputs.forEach(input => {
                if (input) {
                    input.type = isCurrentlyPassword ? 'text' : 'password';
                }
            });

            if (isCurrentlyPassword) {
                eyeTag.classList.remove('fa-eye-slash');
                eyeTag.classList.add('fa-eye');
                eyeTag.style.color = '#2563eb';
            } else {
                eyeTag.classList.remove('fa-eye');
                eyeTag.classList.add('fa-eye-slash');
                eyeTag.style.color = '#94a3b8';
            }
        };

        eyeTag.addEventListener('click', toggleVisibility);
        eyeTag.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                toggleVisibility();
            }
        });
    });
}

/**
 * 2. Real-Time Table Search & Filter
 */
function initLiveTableSearch() {
    const tables = document.querySelectorAll('table#waiting_table, .container table');

    tables.forEach((table, index) => {
        // Skip if table has only 1 row (header only) or already has a search bar
        const tbody = table.querySelector('tbody') || table;
        const rows = Array.from(tbody.querySelectorAll('tr')).filter((_, i) => i > 0);
        if (rows.length === 0) return;

        // Create search bar container above table
        const searchContainer = document.createElement('div');
        searchContainer.className = 'table_search_wrapper';
        searchContainer.innerHTML = `
            <div class="search_input_group">
                <i class="fa-solid fa-magnifying-glass search_icon"></i>
                <input type="text" class="table_search_input" placeholder="Quick search records..." aria-label="Search table">
                <span class="search_counter">${rows.length} records</span>
            </div>
        `;

        table.parentNode.insertBefore(searchContainer, table);

        const searchInput = searchContainer.querySelector('.table_search_input');
        const counter = searchContainer.querySelector('.search_counter');

        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase().trim();
            let visibleCount = 0;

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(query)) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            counter.textContent = `${visibleCount} of ${rows.length} records`;
        });
    });
}

/**
 * 3. Interactive Confirmations for Destructive Actions
 */
function initDestructiveActionConfirmations() {
    const destructiveForms = document.querySelectorAll('form.unstyle_form, form[action*="cancel"], form[action*="remove"], form[action*="suspend"]');

    destructiveForms.forEach(form => {
        const actionInput = form.querySelector('input[name="action"]');
        const action = actionInput ? actionInput.value : '';

        form.addEventListener('submit', (e) => {
            let message = 'Are you sure you want to proceed with this action?';

            if (action === 'cancel_application') {
                message = 'Are you sure you want to cancel this student application? This action cannot be undone.';
            } else if (action === 'suspend_temp_locker') {
                message = 'Are you sure you want to suspend this locker?';
            } else if (action === 'remove_from_waiting_list') {
                message = 'Are you sure you want to remove this student from the waiting list?';
            }

            if (!confirm(message)) {
                e.preventDefault();
            }
        });
    });

    // Disable buttons handling
    const disableBtns = document.querySelectorAll('.disable_btn');
    disableBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
        });
    });
}

/**
 * 4. Button Click Ripple & Micro-Interaction
 */
function initButtonRipples() {
    const buttons = document.querySelectorAll('.btnSubmit, .portal_card, #dropdown button');

    buttons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const ripple = document.createElement('span');
            ripple.className = 'ripple_effect';
            ripple.style.left = `${x}px`;
            ripple.style.top = `${y}px`;

            this.appendChild(ripple);

            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
}

/**
 * 5. Navigation Tab Smooth Effects
 */
function initNavTabEffects() {
    const navItems = document.querySelectorAll('#nav a.nav_item');
    navItems.forEach(item => {
        item.addEventListener('mouseenter', () => {
            item.style.transition = 'all 0.25s cubic-bezier(0.4, 0, 0.2, 1)';
        });
    });
}

/**
 * 6. User Profile Dropdown Toggle & Click Outside
 */
function initDropdownToggle() {
    const dropdown = document.querySelector('#dropdown');
    if (!dropdown) return;

    const button = dropdown.querySelector('button');
    if (!button) return;

    button.addEventListener('click', (e) => {
        e.stopPropagation();
        dropdown.classList.toggle('open');
    });

    document.addEventListener('click', (e) => {
        if (!dropdown.contains(e.target)) {
            dropdown.classList.remove('open');
        }
    });
}

/**
 * 7. Dark / Light Mode Theme Toggle
 */
function initThemeToggle() {
    const toggleBtn = document.querySelector('#theme_toggle');
    if (!toggleBtn) return;

    const icon = toggleBtn.querySelector('i');
    const currentTheme = document.documentElement.getAttribute('data-theme') || 'light';
    updateThemeIcon(icon, currentTheme);

    toggleBtn.addEventListener('click', () => {
        const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
        const newTheme = isDark ? 'light' : 'dark';

        document.documentElement.setAttribute('data-theme', newTheme);
        localStorage.setItem('mandla_theme', newTheme);
        updateThemeIcon(icon, newTheme);
    });
}

function updateThemeIcon(icon, theme) {
    if (!icon) return;
    if (theme === 'dark') {
        icon.classList.remove('fa-moon');
        icon.classList.add('fa-sun');
        icon.style.color = '#fbbf24';
    } else {
        icon.classList.remove('fa-sun');
        icon.classList.add('fa-moon');
        icon.style.color = '';
    }
}