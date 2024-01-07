<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\DatabaseSeedController;
use Tymon\JWTAuth\Facades\JWTAuth;

use Illuminate\Support\Facades\Gate;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataVisualizationController;

use App\Http\Controllers\AppliedFormController;
use App\Http\Controllers\TestController;

use App\Http\Controllers\ExportController;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard/{formStatus?}', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/visualize', [DataVisualizationController::class, 'index'])->name('visualize');

    Route::get('/formshow/{formid}', [DashboardController::class, 'getFormSlug'])->name('forms.get');

    Route::get('/export-to-excel', 'YourController@exportToExcel')->name('export.to.excel');

    Route::get('export/array', [ExportController::class, 'array'])->name('export.array');
    Route::get("/send-mail", [ExportController::class, 'sendMail'])->name('send.mail');

    Route::post('/approve-sekreterlik/{formid}', [FormsController::class, 'approveSekreterlik'])->name('approve.sekreterlik');
    Route::post('/approve-etikkurul/{formid}', [FormsController::class, 'approveEtikkurul'])->name('approve.etikkurul');

    Route::get('/dil-degistir', [DashboardController::class, 'changeLanguageToTurkish']);

    Route::delete('/delete-form/{formid}', [FormsController::class, 'deleteFormById']);

    Route::get('/show-pdf/{path}', function ($path) {
        $filePath = storage_path("app/{$path}");

        if (file_exists($filePath)) {
            return response()->file($filePath);
        } else {
            abort(404, 'File not found');
        }
    })->where('path', '.*');

    Route::post('/forms/approve/{formid}', [FormsController::class, 'approveSekreterlik']);
    Route::get('/pdf/{slug}', [DashboardController::class, 'generatePdf']);
});





Route::get('/query-etikkurul/{student_no}', [FormsController::class, 'generateQueryStageForm'])->name('forms.get');
Route::get('/form/{formId?}', [FormsController::class, 'index'])->name('forms.index');


Route::view('/', 'root.index')->name('root.index');

Route::post('store-form/{formId?}', [FormsController::class, 'store'])->name('forms.store');
Route::get('/seed-database', [DatabaseSeedController::class, 'seed']);
Route::get('generate', function () {
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    echo 'ok';
});

Route::get('migrate', function () {
    \Illuminate\Support\Facades\Artisan::call('db:seed');

    echo 'ok';
});

use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

Route::get('tken', function () {
    $loginData = [
        'university_id' => "20202022043",
        'password' => "Gorkemdabbeosman33*",
    ];
    $url = "https://sanalkampus.nisantasi.edu.tr/?returnUrl=%2FHome%2FIndex";
    $data = [
        'Password' => $loginData["password"],
    ];
    $cookies = [
        "CookUserName" => $loginData["university_id"],
    ];

    $response = Http::withHeaders(['Cookie' => http_build_query($cookies, '', '; ')])->withoutRedirecting()->post($url, $data);
    $htmlContent = $response->body();

    $crawler = new Crawler($htmlContent);

    $linkHref = $crawler->filter('h2 a')->attr('href');

    $parsedUrl = parse_url($linkHref);
    $queryParams = [];
    if (isset($parsedUrl['query'])) {
        parse_str($parsedUrl['query'], $queryParams);
    }

    // Get the token value
    $tokenFirst = isset($queryParams['token']) ? $queryParams['token'] : '';

    $url = "https://almsp-prod-api.almscloud.com/api/account/decryptoken";
    $token = $tokenFirst;

    $response = Http::withHeaders([
        "Accept" => "application/json",
        "Accept-Language" => "tr-TR",
        "Access-Control-Allow-Origin" => "*",
        "Authorization" => "Bearer",
        "Cache-Control" => "no-cache",
        "Content-Type" => "application/json",
        "Pragma" => "no-cache",
    ])
        ->post($url, [
            "Token" => $token,
            "Host" => "sanalkampus.nisantasi.edu.tr",
            "Port" => "",
        ]);

    // Handle the response
    $status = $response->status();

    $content = $response->json();

    if ($status === 200) {
        // Output the response
        $parts = explode('.', $content["access_token"]);

        // Check if the second part exists before decoding it
        if (isset($parts[1])) {
            $decodedToken = json_decode(base64_decode($parts[1]), true);

            // Check if the fields exist before accessing them
            $name = isset($decodedToken['name']) ? $decodedToken['name'] : null;
            $familyName = isset($decodedToken['familyname']) ? $decodedToken['familyname'] : null;
            $emailAddress = isset($decodedToken['emailaddress']) ? $decodedToken['emailaddress'] : null;

            $respons = response()->json([
                'name' => $name,
                'lastname' => $familyName,
                'email' => $emailAddress,
            ]);
            $content = $respons->getContent();
            $decodedData = json_decode($content, true);
            return $decodedToken;
        } else {
            echo "Error decoding token";
        }
    } else {
        return response()->json([
            'error' => 'Unauthorized',
            'message' => 'Invalid credentials',
        ], 401);
    }
});
