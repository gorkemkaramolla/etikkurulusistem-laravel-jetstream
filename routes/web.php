<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataVisualizationController;
use App\Http\Controllers\AdminFeaturesController;


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::controller(FormsController::class)->group(function () {
        Route::get('/form/{formId?}', 'index')->name('forms.index');
        Route::get('/query-etikkurul/{formid}',  'generateQueryStageForm');
    });
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard/{formStatus?}', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/formshow/{formid}', [DashboardController::class, 'getFormSlug'])->name('forms.get');
    });
    Route::controller(AdminFeaturesController::class)->group(function () {
        Route::get('/adminfeatures', 'index')->name('adminfeatures.index');
    });
    Route::get('/visualize', [DataVisualizationController::class, 'index'])->name('visualize');
    Route::get('/show-pdf/{path}', function ($path) {
        $filePath = storage_path("app/{$path}");

        if (file_exists($filePath)) {
            return response()->file($filePath, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . basename($filePath) . '"'
            ]);
        } else {
            abort(404, 'File not found');
        }
    })->where('path', '.*');
});
Route::get("/info", function () {
    return view('info.index');
});
Route::view('/', 'root.index')->name('root.index');

// Route::get('/seed-database', [DatabaseSeedController::class, 'seed']);
// Route::get('generate', function () {
//     \Illuminate\Support\Facades\Artisan::call('storage:link');
//     echo 'ok';
// });

// Route::get('migrate', function () {
//     \Illuminate\Support\Facades\Artisan::call('db:seed');

//     echo 'ok';
// });



//h25514327122
// Route::get('tken', function () {
//     $loginData = [
//         'university_id' => "20202022043",
//         'password' => "Gorkemdabbeosman33*",
//     ];
//     $url = "https://sanalkampus.nisantasi.edu.tr/?returnUrl=%2FHome%2FIndex";
//     $data = [
//         'Password' => $loginData["password"],
//     ];
//     $cookies = [
//         "CookUserName" => $loginData["university_id"],
//     ];

//     $response = Http::withHeaders(['Cookie' => http_build_query($cookies, '', '; ')])->withoutRedirecting()->post($url, $data);
//     $htmlContent = $response->body();

//     $crawler = new Crawler($htmlContent);

//     $linkHref = $crawler->filter('h2 a')->attr('href');

//     $parsedUrl = parse_url($linkHref);
//     $queryParams = [];
//     if (isset($parsedUrl['query'])) {
//         parse_str($parsedUrl['query'], $queryParams);
//     }

//     // Get the token value
//     $tokenFirst = isset($queryParams['token']) ? $queryParams['token'] : '';

//     $url = "https://almsp-prod-api.almscloud.com/api/account/decryptoken";
//     $token = $tokenFirst;

//     $response = Http::withHeaders([
//         "Accept" => "application/json",
//         "Accept-Language" => "tr-TR",
//         "Access-Control-Allow-Origin" => "*",
//         "Authorization" => "Bearer",
//         "Cache-Control" => "no-cache",
//         "Content-Type" => "application/json",
//         "Pragma" => "no-cache",
//     ])
//         ->post($url, [
//             "Token" => $token,
//             "Host" => "sanalkampus.nisantasi.edu.tr",
//             "Port" => "",
//         ]);

//     // Handle the response
//     $status = $response->status();

//     $content = $response->json();

//     if ($status === 200) {
//         // Output the response
//         $parts = explode('.', $content["access_token"]);

//         // Check if the second part exists before decoding it
//         if (isset($parts[1])) {
//             $decodedToken = json_decode(base64_decode($parts[1]), true);

//             // Check if the fields exist before accessing them
//             $name = isset($decodedToken['name']) ? $decodedToken['name'] : null;
//             $familyName = isset($decodedToken['familyname']) ? $decodedToken['familyname'] : null;
//             $emailAddress = isset($decodedToken['emailaddress']) ? $decodedToken['emailaddress'] : null;

//             $respons = response()->json([
//                 'name' => $name,
//                 'lastname' => $familyName,
//                 'email' => $emailAddress,
//             ]);
//             $content = $respons->getContent();
//             $decodedData = json_decode($content, true);
//             return $decodedData;
//         } else {
//             echo "Error decoding token";
//         }
//     } else {
//         return response()->json([
//             'error' => 'Unauthorized',
//             'message' => 'Invalid credentials',
//         ], 401);
//     }
// });