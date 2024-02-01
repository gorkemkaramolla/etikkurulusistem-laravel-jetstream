<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramEnum;

class EnumController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'parent' => 'required|string',
            'field' => 'required|string',
        ]);

        // Get the existing fields from the database or a default value
        $programs = ProgramEnum::first() ?? new ProgramEnum();

        // Get the existing fields or an empty array
        $fields = $programs->fields ?? [];

        // Add the new field to the parent
        $fields[$request->parent][] = $request->field;

        // Save the fields back to the database
        $programs->fields = $fields;
        $programs->save();

        return back()->with('success', 'Field added successfully.');
    }
    public function destroy(Request $request)
    {
        $request->validate([
            'parent' => 'required|string',
        ]);

        // Get the existing fields from the database or a default value
        $programs = ProgramEnum::first();

        if (!$programs) {
            return response()->json(['error' => 'No programs found.'], 404);
        }

        // Get the existing fields or an empty array
        $fields = $programs->fields ?? [];

        // Check if the parent exists in the fields
        if (!isset($fields[$request->parent])) {
            return response()->json(['error' => 'Parent not found.'], 404);
        }

        // Remove the parent from the fields
        unset($fields[$request->parent]);

        // Save the fields back to the database
        $programs->fields = $fields;
        $programs->save();

        return response()->json(['success' => 'Parent deleted successfully.'], 200);
    }
}
