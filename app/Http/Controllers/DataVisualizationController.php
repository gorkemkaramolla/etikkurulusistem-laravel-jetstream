<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use App\Models\Form;
use Illuminate\Http\Request;

class DataVisualizationController extends Controller
{
    public function index()
    {
        $formsByYear = Form::select(
            DB::raw('YEAR(created_at) as year'), // Extract year from the created_at column
            DB::raw('COUNT(id) as count') // Count the number of forms for each year
        )
            ->groupBy('year') // Group by year
            ->orderBy('year')
            ->get(); // Use get() instead of pluck

        return view("visualize.index", compact('formsByYear'));
    }
}
