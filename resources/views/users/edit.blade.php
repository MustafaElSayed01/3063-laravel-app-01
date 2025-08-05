<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit User</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center py-10">
    <form id="editUserForm" class="w-full max-w-lg bg-white rounded-2xl shadow-md p-8 space-y-6" novalidate>
        <!-- adjust action as needed -->
        <h1 class="text-2xl font-semibold text-gray-900 text-center">Edit User</h1>

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
            <input type="text" name="name" id="name" required value="{{ $user['name'] }}"
                class="peer w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 invalid:border-red-500"
                placeholder="John Doe" />
            <p class="mt-1 text-sm text-red-600 hidden" data-error-for="name">Name is required.</p>
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
            <input type="email" name="email" id="email" required value="{{ $user['email'] }}"
                class="peer w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 invalid:border-red-500"
                placeholder="you@example.com" />
            <p class="mt-1 text-sm text-red-600 hidden" data-error-for="email">Please provide a valid email.</p>
        </div>

        <!-- Phone with +20 prefix -->
        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
            <div class="flex">
                <span
                    class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-gray-300 bg-gray-100 text-gray-700 text-sm">
                    +20
                </span>
                <input type="tel" name="phone" id="phone" required pattern="\d{9}" value="{{ $user['phone'] }}"
                    class="peer flex-1 min-w-0 w-full rounded-r-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 invalid:border-red-500"
                    placeholder="10-digit number (e.g., 123456789)" maxlength="9" />
            </div>
            <p class="mt-1 text-sm text-red-600 hidden" data-error-for="phone">Enter 9 digits after +20.</p>
        </div>

        <!-- Role radios -->
        <fieldset>
            <legend class="text-sm font-medium text-gray-700 mb-1">Role</legend>
            <div class="flex gap-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="role" value="admin" required class="peer sr-only" />
                    <div
                        class="px-4 py-2 rounded-lg border border-gray-300 cursor-pointer select-none peer-checked:border-indigo-600 peer-checked:bg-indigo-50 peer-checked:ring-1 peer-checked:ring-indigo-500">
                        Admin
                    </div>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="role" value="manager" class="peer sr-only" />
                    <div
                        class="px-4 py-2 rounded-lg border border-gray-300 cursor-pointer select-none peer-checked:border-indigo-600 peer-checked:bg-indigo-50 peer-checked:ring-1 peer-checked:ring-indigo-500">
                        Manager
                    </div>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="role" value="user" class="peer sr-only" />
                    <div
                        class="px-4 py-2 rounded-lg border border-gray-300 cursor-pointer select-none peer-checked:border-indigo-600 peer-checked:bg-indigo-50 peer-checked:ring-1 peer-checked:ring-indigo-500">
                        User
                    </div>
                </label>
            </div>
            <p class="mt-1 text-sm text-red-600 hidden" data-error-for="role">Select a role.</p>
        </fieldset>

        <div>
            <button type="submit"
                class="w-full flex justify-center items-center gap-2 rounded-2xl bg-indigo-600 px-5 py-3 text-white font-medium hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-300 transition mb-4">
                Edit User
            </button>
            <a href="/users"
                class="w-full flex justify-center items-center gap-2 rounded-2xl bg-indigo-600 px-5 py-3 text-white font-medium hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-300 transition">
                View All Users
            </a>
        </div>
    </form>

    <script>
    const form = document.getElementById('addUserForm');

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        let valid = true;
        form.querySelectorAll('[data-error-for]').forEach(el => el.classList.add('hidden'));

        // Name
        if (!form.name.value.trim()) {
            showError('name');
            valid = false;
        }

        // Email
        if (!form.email.checkValidity()) {
            showError('email');
            valid = false;
        }

        // Phone: expecting 9 digits after +20
        const phoneVal = form.phone.value.trim();
        if (!/^\d{9}$/.test(phoneVal)) {
            showError('phone');
            valid = false;
        }

        // Role
        if (!form.role.value) {
            showError('role');
            valid = false;
        }

        if (valid) {
            form.submit();
        }
    });

    function showError(field) {
        const err = document.querySelector(`[data-error-for="${field}"]`);
        if (err) err.classList.remove('hidden');
        const input = document.getElementById(field);
        if (input) input.classList.add('border-red-500');
        if (field === 'role') {
            const legend = document.querySelector('legend[for="role"]');
            if (legend) legend.classList.add('text-red-500');
        }
    }
    </script>
</body>

</html>
