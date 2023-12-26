<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Form;

class ExportController extends Controller
{
    public function array()
    {
        // Use the storage disk to create the file
        $handle = fopen(storage_path('app/public/export.csv'), 'w');

        // Check if the file was opened successfully
        if ($handle === false) {
            return response()->json(['error' => 'Unable to open file for writing.']);
        }

        // Use lazy loading to retrieve and export data
        Form::query()->lazyById(2000, 'id')
            ->each(function ($user) use ($handle) {
                fputcsv($handle, $user->toArray());
            });

        // Close the file handle
        fclose($handle);

        // Use the storage disk to download the file
        return Storage::disk('public')->download('export.csv');
    }
}
