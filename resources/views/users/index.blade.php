<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Users Page</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-50 min-h-screen">
    <main class="max-w-7xl mx-auto p-6">
        <header class="mb-6 text-center">
            <h1 class="text-3xl font-bold mb-2">Users</h1>
            <p class="text-gray-600">List of all users. Use the search to filter by name, email, or role.</p>
        </header>

        <!-- Search + optional server-side pagination controls -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
            <div class="flex-1">
                <label for="search" class="sr-only">Search users</label>
                <input id="search" type="text" placeholder="Search by name, email, phone number or role"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    aria-label="Search users" />
            </div>
        </div>

        <!-- Table container -->
        <div class="overflow-x-auto bg-white rounded-2xl shadow">
            <table class="min-w-full divide-y divide-gray-200" aria-label="Users table">
                <caption class="sr-only">Users list</caption>
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Role</th>
                    </tr>
                </thead>
                <tbody id="usersTbody" class="bg-white divide-y divide-gray-200">
                    <?php    foreach ($users as $user): ?>
                    <?php
    $name = htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8');
    $phone = htmlspecialchars($user['phone'], ENT_QUOTES, 'UTF-8');
    $role = htmlspecialchars($user['role'], ENT_QUOTES, 'UTF-8');
                    ?>
                    <tr class="hover:bg-gray-50 focus-within:bg-gray-100">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= $name ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= $email ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= $phone ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= $role ?></td>
                    </tr>
                    <?php    endforeach; ?>
                </tbody>
            </table>
            <div id="noResults" class="hidden">
                <p class="px-6 py-4 text-center text-gray-500">No users found.</p>
            </div>
            <div class="flex justify-end mb-4">
                <a href="/users/create"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-dark">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add User
                </a>
            </div>
        </div>

        <!-- JavaScript search/filter (client-side) -->
        <noscript>
            <p class="mt-4 text-sm text-yellow-700">JavaScript is disabled; live search won’t work. Showing full page
                results.</p>
        </noscript>
        <script>
            (() => {
                const input = document.getElementById('search');
                const tbody = document.getElementById('usersTbody');
                if (!input || !tbody) return;

                input.addEventListener('input', () => {
                    const q = input.value.toLowerCase().trim();
                    [...tbody.querySelectorAll('tr')].forEach(row => {
                        if (row.querySelector('td[colspan]')) return;
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(q) ? '' : 'none';
                    });
                    const visible = [...tbody.querySelectorAll('tr')].some(row => row.style.display !== 'none');
                    if (!visible) {
                        document.getElementById('noResults').classList.remove('hidden');
                    } else {
                        document.getElementById('noResults').classList.add('hidden');
                    }
                });
            })();
        </script>
    </main>
</body>

</html>