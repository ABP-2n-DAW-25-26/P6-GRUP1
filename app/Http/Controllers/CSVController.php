<?php

namespace App\Http\Controllers;

use App\Mail\TestMail;
use App\Models\Exchange;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CSVController extends Controller
{
    public function downloadCsvTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template.csv"',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['name', 'surname', 'email']);
            fputcsv($file, ['example', 'example', 'exampl@example.com']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function importCSV(Request $request)
    {
        $validated = $request->validate([
            'csv' => 'required|file|mimes:csv,txt',
            'exchangeId' => 'required|integer'
        ]);
        $exchange = Exchange::findorFail($validated['exchangeId']);

        $file = $request->file('csv');

        $handle = fopen($file->getRealPath(), 'r');

        $header = fgetcsv($handle);
        while (($row = fgetcsv($handle)) !== false) {
            [$name, $surname, $email] = $row;

            $password = Str::random(12);

            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'surname' => $surname,
                    'role' => 'student',
                    'password' => Hash::make($password),
                ]
            );

            if ($user->wasRecentlyCreated) {
                // Mail::to($email)->send(...) TODO
                Mail::to($email)->send(new TestMail());
            }

            $exchange->users()->syncWithoutDetaching([$user->id]);
        }

        fclose($handle);

        return back()->with('success', 'Usuarios importados correctamente');
    }
}
