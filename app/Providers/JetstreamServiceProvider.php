<?php

namespace App\Providers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Fortify;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

use App\Actions\Jetstream\DeleteUser;
use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }


    public function boot(): void
    {
        $this->configurePermissions();
        Fortify::authenticateUsing(function (Request $request) {

            $userLoginField = $request->email;
            $user = User::where('email', $userLoginField)
                ->orWhere('student_no', $userLoginField)
                ->first();


            if ($user) {
                $isEmail = filter_var($userLoginField, FILTER_VALIDATE_EMAIL);
                if ($user) {
                    if (Hash::check($request->password, $user->password)) {
                        return $user;
                    }
                }
            } else {


                $data = [
                    'university_id' => $request->email,
                    'password' => $request->password,
                ];
                $authInformations = JetstreamServiceProvider::loginToSanalKampus($data);

                $content = $authInformations->getContent();
                $decodedData = json_decode($content, true);



                $name = $decodedData["name"];
                $lastname = $decodedData["lastname"];
                $email = $decodedData["email"];

                $user = User::create([
                    "name" => $name,
                    "lastname" => $lastname,
                    "email" =>  $email,
                    'student_no' => $request['email'],
                    'password' => Hash::make($request['password']),
                    "role" => "user",
                ]);
                return $user;
            }
        });
        Jetstream::deleteUsersUsing(DeleteUser::class);
    }
    // public function getStudentInformation($university_id)
    // {
    //     $url = "https://ats.nisantasi.edu.tr/nisantasi-help";
    //     $data = [
    //         "ogrenci_no" => $university_id,
    //         'name' => 'bilgi_getir'
    //     ];
    //     // Make the HTTP POST request
    //     $response = Http::asForm()->post($url, $data);

    //     // Access the form_bilgi key
    //     $formBilgi = (string) $response->json()['form_bilgi'];

    //     // Create a new Crawler instance
    //     $crawler = new Crawler($formBilgi);

    //     // Create an array to store values
    //     $studentInfo = [
    //         'name' => $crawler->filter('.adsoyad')->attr('value'),
    //         'department' => $crawler->filter('.bolum')->attr('value'),
    //         'class' => $crawler->filter('.sinif')->attr('value'),
    //         'email' => $crawler->filter('.profil_eposta')->attr('value'),
    //     ];
    //     return $studentInfo;
    // }

    protected function configurePermissions(): void
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::permissions([
            'create',
            'read',
            'update',
            'delete',
        ]);
    }

    // protected function loginToSanalkampus($credentials)
    // {
    //     $url = "https://sanalkampus.nisantasi.edu.tr/?returnUrl=%2FHome%2FIndex";
    //     $data = [
    //         'Password' => $credentials["password"],
    //     ];
    //     $cookies = [
    //         "CookUserName" => $credentials["university_id"],
    //     ];

    //     $response = Http::withHeaders(['Cookie' => http_build_query($cookies, '', '; ')])->withoutRedirecting()->post($url, $data);
    //     echo $response->json();
    //     // return $response->header("Location") != "/";
    // }
    protected function loginToSanalkampus($credentials)
    {
        try {
            $url = "https://sanalkampus.nisantasi.edu.tr/?returnUrl=%2FHome%2FIndex";
            $data = [
                'Password' => $credentials["password"],
            ];
            $cookies = [
                "CookUserName" => $credentials["university_id"],
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

                    return response()->json([
                        'name' => $name,
                        'lastname' => $familyName,
                        'email' => $emailAddress,
                    ]);
                } else {
                    echo "Error decoding token";
                }
            } else {
                return response()->json([
                    'error' => 'Unauthorized',
                    'message' => 'Invalid credentials',
                ], 401);
            }
        } catch (Exception $e) {
            echo $e;
        }
    }
}
