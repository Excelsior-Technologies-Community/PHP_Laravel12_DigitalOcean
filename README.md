# PHP_Laravel12_DigitalOcean


## Project Description

PHP_Laravel12_DigitalOcean is a simple Laravel 12 web application that demonstrates how to integrate the DigitalOcean API using the graham-campbell/digitalocean package.

The application simulates a small DigitalOcean dashboard where users can view available regions, droplet sizes, and droplet servers.

This project helps developers understand how Laravel can communicate with external APIs and display cloud infrastructure information in a clean dashboard interface.

Since the real DigitalOcean API requires billing access, this project uses mock data to simulate the expected output while still demonstrating the proper package installation and structure.


## Features:

- Display available DigitalOcean regions

- Display Droplet server sizes

- Display Droplet server list

- Clean dashboard style UI

- Laravel MVC architecture

- Easy to understand project structure

- Demonstrates DigitalOcean Laravel package usage


## Technologies Used

- PHP 8.2+
- Laravel 12
- Blade Template Engine
- MySQL (optional)
- Composer
- graham-campbell/digitalocean Package


---



## Installation Steps


---


## STEP 1: Create Laravel 12 Project

### Open terminal / CMD and run:

```
composer create-project laravel/laravel PHP_Laravel12_DigitalOcean "12.*"

```

### Go inside project:

```
cd PHP_Laravel12_DigitalOcean

```

#### Explanation:

This command installs a fresh Laravel 12 application using Composer.

The cd command moves into the created project folder so we can run Laravel commands.




## STEP 2: Database Setup (Optional)

### Update database details:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel12_DigitalOcean
DB_USERNAME=root
DB_PASSWORD=

```

### Create database in MySQL / phpMyAdmin:

```
Database name: laravel12_DigitalOcean

```

### Then Run:

```
php artisan migrate

```


#### Explanation:

This step configures the MySQL database connection in the .env file.

Running the migration command creates Laravel’s default tables in the database.




## STEP 3: Install DigitalOcean Laravel Package

### Install the package used in the reference repository:

```
composer require graham-campbell/digitalocean

```


### Also install HTTP client dependency.

```
composer require guzzlehttp/guzzle

```



#### Explanation:

The package provides a Laravel wrapper for the DigitalOcean API.

Guzzle is required to send HTTP requests from Laravel to the DigitalOcean servers.




## STEP 4: Publish Configuration File

### Run:

```
php artisan vendor:publish

```

### Select:

```
GrahamCampbell\DigitalOcean\DigitalOceanServiceProvider

```

### Now a new file will be created:

```
config/digitalocean.php

```


### Explanation:

This command publishes the package configuration file into the Laravel project.

The config/digitalocean.php file allows us to configure API tokens and connection settings.







## STEP 5: Configure config/digitalocean.php

### Open: config/digitalocean.php

```
<?php

return [

    'default' => 'main',

    'connections' => [

        'main' => [
            'token' => env('DIGITALOCEAN_TOKEN'),
        ],

        'alternative' => [
            'token' => env('DIGITALOCEAN_TOKEN'),
        ],

    ],

];

```

#### Explanation:

This configuration file defines the connection settings for the DigitalOcean API.

The API token is loaded from the .env file using the env('DIGITALOCEAN_TOKEN') function.



## STEP 6: Create Controller

### Run:

```
php artisan make:controller DigitalOceanController

```

### File: app/Http/Controllers/DigitalOceanController.php

```
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GrahamCampbell\DigitalOcean\Facades\DigitalOcean;

class DigitalOceanController extends Controller
{

    public function regions()
    {
        // Mock data (since API requires payment)
        $regions = [
            (object) ['name' => 'New York'],
            (object) ['name' => 'London'],
            (object) ['name' => 'Singapore'],
            (object) ['name' => 'Frankfurt'],
        ];

        return view('regions', compact('regions'));
    }

    public function sizes()
    {
        $sizes = [
            (object) ['slug' => 's-1vcpu-1gb', 'memory' => '1024MB'],
            (object) ['slug' => 's-1vcpu-2gb', 'memory' => '2048MB'],
            (object) ['slug' => 's-2vcpu-2gb', 'memory' => '4096MB'],
        ];

        return view('sizes', compact('sizes'));
    }

    public function droplets()
    {
        $droplets = [
            (object) ['name' => 'server-1'],
            (object) ['name' => 'server-2'],
        ];

        return view('droplets', compact('droplets'));
    }

}

```

#### Explanation:

The controller handles application logic and communicates with the DigitalOcean service.

It sends data to Blade views so it can be displayed on the web pages.




## STEP 7: Create Routes

### Open: routes/web.php

```
use App\Http\Controllers\DigitalOceanController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/regions', [DigitalOceanController::class, 'regions']);
Route::get('/sizes', [DigitalOceanController::class, 'sizes']);
Route::get('/droplets', [DigitalOceanController::class, 'droplets']);

```

#### Explanation

Routes define the URLs that users can access in the application.

Each route calls a controller method that returns a specific view.





## STEP 8: Create Views

### resources/views/regions.blade.php

```
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>DigitalOcean Regions</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Segoe UI, Arial
        }

        body {
            background: linear-gradient(135deg, #0f172a, #1e293b);
            min-height: 100vh;
            color: #fff;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logo {
            font-size: 20px;
            font-weight: bold;
        }

        .navbar a {
            color: #fff;
            text-decoration: none;
            margin-left: 20px;
            padding: 6px 14px;
            border-radius: 6px;
            transition: 0.3s;
        }

        .navbar a:hover {
            background: #2563eb;
        }

        .container {
            max-width: 1000px;
            margin: 60px auto;
            padding: 20px;
        }

        .card {
            background: rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            backdrop-filter: blur(12px);
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .title {
            font-size: 26px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 14px;
            text-align: left;
        }

        th {
            background: #1e40af;
        }

        tr:nth-child(even) {
            background: rgba(255, 255, 255, 0.05);
        }

        tr:hover {
            background: rgba(37, 99, 235, 0.3);
        }

        .badge {
            background: #22c55e;
            padding: 4px 10px;
            border-radius: 5px;
            font-size: 12px;
        }
    </style>
</head>

<body>

    <div class="navbar">
        <div class="logo">DigitalOcean Dashboard</div>
        <div>
            <a href="/regions">Regions</a>
            <a href="/sizes">Sizes</a>
            <a href="/droplets">Droplets</a>
        </div>
    </div>

    <div class="container">

        <div class="card">

            <div class="title">🌍 Available Regions</div>

            <table>
                <tr>
                    <th>#</th>
                    <th>Region Name</th>
                    <th>Status</th>
                </tr>

                @foreach($regions as $index => $region)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $region->name }}</td>
                        <td><span class="badge">Active</span></td>
                    </tr>
                @endforeach

            </table>

        </div>

    </div>

</body>

</html>

```



### resources/views/sizes.blade.php

```
<!DOCTYPE html>
<html>

<head>
    <title>Droplet Sizes</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Segoe UI, Arial;
        }

        body {
            background: linear-gradient(135deg, #020617, #0f172a);
            color: white;
            min-height: 100vh;
        }

        /* NAVBAR */

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 40px;
            background: rgba(255, 255, 255, 0.05);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-weight: 500;
        }

        .navbar a:hover {
            color: #3b82f6;
        }

        /* CONTAINER */

        .container {
            max-width: 1000px;
            margin: 80px auto;
            padding: 20px;
        }

        /* CARD */

        .card {
            background: rgba(255, 255, 255, 0.07);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
        }

        /* TITLE */

        .title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 25px;
        }

        /* TABLE */

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        thead {
            background: #2563eb;
        }

        th {
            padding: 14px;
            text-align: left;
            font-weight: 600;
        }

        td {
            padding: 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        /* COLUMN WIDTHS */

        th:nth-child(1),
        td:nth-child(1) {
            width: 60px;
            text-align: center;
        }

        th:nth-child(2),
        td:nth-child(2) {
            width: 400px;
        }

        th:nth-child(3),
        td:nth-child(3) {
            width: 150px;
            text-align: right;
        }

        /* MEMORY COLOR */

        .memory {
            color: #22c55e;
            font-weight: 600;
        }

        /* HOVER */

        tbody tr:hover {
            background: rgba(59, 130, 246, 0.15);
        }
    </style>

</head>

<body>

    <div class="navbar">
        <div><b>DigitalOcean Dashboard</b></div>

        <div>
            <a href="/regions">Regions</a>
            <a href="/sizes">Sizes</a>
            <a href="/droplets">Droplets</a>
        </div>
    </div>

    <div class="container">

        <div class="card">

            <div class="title">💻 Droplet Sizes</div>

            <table>

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Slug</th>
                        <th>Memory</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($sizes as $index => $size)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $size->slug }}</td>
                            <td class="memory">{{ $size->memory }}</td>
                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</body>

</html>

```


### resources/views/droplets.blade.php

```
<!DOCTYPE html>
<html>

<head>
    <title>Droplets</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Segoe UI
        }

        body {
            background: linear-gradient(135deg, #020617, #0f172a);
            color: white;
            min-height: 100vh;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            padding: 15px 40px;
            background: rgba(255, 255, 255, 0.05);
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
        }

        .container {
            max-width: 900px;
            margin: 60px auto;
        }

        .card {
            background: rgba(255, 255, 255, 0.08);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
        }

        h2 {
            margin-bottom: 20px;
        }

        .server {
            padding: 14px;
            margin-bottom: 12px;
            border-radius: 8px;
            background: rgba(59, 130, 246, 0.3);
            transition: 0.3s;
        }

        .server:hover {
            transform: scale(1.03);
            background: #2563eb;
        }
    </style>

</head>

<body>

    <div class="navbar">
        <div>DigitalOcean Dashboard</div>
        <div>
            <a href="/regions">Regions</a>
            <a href="/sizes">Sizes</a>
            <a href="/droplets">Droplets</a>
        </div>
    </div>

    <div class="container">

        <div class="card">

            <h2>☁️ Droplet Servers</h2>

            @foreach($droplets as $droplet)
                <div class="server">
                    {{ $droplet->name }}
                </div>
            @endforeach

        </div>

    </div>

</body>

</html>

```

#### Explanation

Views are responsible for displaying data to the user using Laravel Blade templates.

These pages show regions, droplet sizes, and droplet servers in a simple dashboard layout.




## STEP 9: Run Project

### Start server

```
php artisan serve

```

### Open in browser

```
http://127.0.0.1:8000/regions

http://127.0.0.1:8000/sizes

http://127.0.0.1:8000/droplets

```

#### Explanation:

The php artisan serve command starts Laravel’s local development server.

Opening the URLs in the browser displays the DigitalOcean dashboard pages.




## Expected Output

### Regions Page:


<img width="1919" height="963" alt="Screenshot 2026-03-09 110108" src="https://github.com/user-attachments/assets/64f57dbd-4003-45ea-a6ac-2e7b86ff8487" />


### Sizes Page:


<img width="1919" height="961" alt="Screenshot 2026-03-09 110118" src="https://github.com/user-attachments/assets/7207f1c9-545f-4bd5-bfbe-d438db066be4" />


### Droplets Page:


<img width="1919" height="922" alt="Screenshot 2026-03-09 110127" src="https://github.com/user-attachments/assets/cf36fcee-5819-47a4-97a1-ae964b821367" />


---

# Project Folder Structure:

```
PHP_Laravel12_DigitalOcean
│
├── app
│   └── Http
│       └── Controllers
│            └── DigitalOceanController.php
│
├── config
│   └── digitalocean.php
│
├── resources
│   └── views
│        ├── regions.blade.php
│        ├── sizes.blade.php
│        └── droplets.blade.php
│
├── routes
│   └── web.php
│
├── .env
│
└── composer.json

```
