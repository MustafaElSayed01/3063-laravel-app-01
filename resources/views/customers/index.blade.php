<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Customers Page</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-50 min-h-screen">
    <main class="max-w-7xl mx-auto p-6">
        <header class="mb-6 text-center">
            <h1 class="text-3xl font-bold mb-2">Customers</h1>
            <p class="text-gray-600">List of all customers. Use the search to filter by name, city, country or phone.
            </p>
        </header>

        <!-- Search + optional server-side pagination controls -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
            <div class="flex-1">
                <label for="search" class="sr-only">Search customers</label>
                <input id="search" type="text" placeholder="Search by name, city, country, phone"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    aria-label="Search customers" />
            </div>
        </div>

        <!-- Table container -->
        <div class="overflow-x-auto bg-white rounded-2xl shadow">
            <table class="min-w-full divide-y divide-gray-200" aria-label="Customers table">
                <caption class="sr-only">Customers list</caption>
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">City
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Country</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone
                        </th>
                    </tr>
                </thead>
                <tbody id="customersTbody" class="bg-white divide-y divide-gray-200">
                    <?php    foreach ($customers as $customer): ?>
                    <?php
    $name = htmlspecialchars($customer['name'], ENT_QUOTES, 'UTF-8');
    $city = htmlspecialchars($customer['city'], ENT_QUOTES, 'UTF-8');
    $country = htmlspecialchars($customer['country'], ENT_QUOTES, 'UTF-8');
    $phone = htmlspecialchars($customer['phone'], ENT_QUOTES, 'UTF-8');
                    ?>
                    <tr class="hover:bg-gray-50 focus-within:bg-gray-100">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= $name ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= $city ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= $country ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= $phone ?></td>
                    </tr>
                    <?php    endforeach; ?>
                </tbody>
            </table>
            <div id="noResults" class="hidden">
                <p class="px-6 py-4 text-center text-gray-500">No customers found.</p>
            </div>
        </div>

        <noscript>
            <p class="mt-4 text-sm text-yellow-700">JavaScript is disabled; live search won’t work. Showing full page
                results.</p>
        </noscript>
        <script>
            (() => {
                const input = document.getElementById('search');
                const tbody = document.getElementById('customersTbody');
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
                        if (!document.getElementById('noResults')) {
                            document.getElementById('noResults').classList.remove('hidden');
                        }
                    } else {
                        document.getElementById('noResults').classList.add('hidden');
                    }
                });
            })();
        </script>
    </main>
</body>

</html>