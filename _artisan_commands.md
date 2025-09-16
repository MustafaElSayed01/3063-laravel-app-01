# Run the server
```bash
php artisan serve
```

# Run the server with a specific port
```bash
php artisan serve --port=8000
```

# Create a new controller
```bash
php artisan make:controller ControllerName
```

# Create a new controller with all methods
```bash
php artisan make:controller ControllerName -r
php artisan make:controller ControllerName --resource
```

<!-- Migrations -->

# Create table 
```bash
php artisan make:migration create_table_name
```

# Run Pending Migrations
```bash
php artisan migrate
```

# Undo Last Migration (Batch)
```bash
php artisan migrate:rollback
```

# Undo spcific steps in the Migration
```bash
php artisan migrate:rollback --step=2
```

# Undo all migrations at once (except migrations table)
```bash
php artisan migrate:reset
```

# Undo all migrations at once, then remigrate (except migrations table)
```bash
php artisan migrate:refresh
```

# Drop all tables and remigrate them all from zero
```bash
php artisan migrate:fresh
```

# Check the migration status
```bash
php artisan migrate:status
```


# Create model
```bash
php artisan make:model Post
```
<!-- Seeders and Factory -->
# Create Seeders and Factories
```bash
php artisan make:seeder UserSeeder
php artisan make:factory UserFactory
```
# Run Seeders
```bash
php artisan db:seed --class=UserSeeder
```
# Run All Seeders
```bash
php artisan db:seed
```
# Re-migrate and seed
```bash
php artisan migrate:fresh --seed
```