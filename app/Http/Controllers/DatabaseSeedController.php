<?php

// app/Http/Controllers/DatabaseSeedController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeedController extends Controller
{
    public function seed()
    {
        // Run the database seeder
        Artisan::call('db:seed');

        return response()->json(['message' => 'Database seeded successfully.']);
    }
}
