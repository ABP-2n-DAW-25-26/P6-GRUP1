<?php

namespace App\Http\Controllers;

use App\Models\Exchange;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AddUsersController extends Controller
{
    public function index(Exchange $exchange)
    {
        return inertia('teacher/AddUsers', [
            'exchangeId' => $exchange->id,
        ]);
    }

    public function create(Exchange $exchange)
    {
        return inertia('teacher/AddUsers', [
            'exchangeId' => $exchange->id,
        ]);
    }

    public function store(Request $request, Exchange $exchange)
    {
        try {
            $request->validate([
                'import_csv' => 'required|mimes:csv,txt|max:5120',
            ]);

            $file = $request->file('import_csv');
            $path = $file->getRealPath();
            $handle = fopen($path, 'r');

            if (!$handle) {
                return back()->withErrors(['import_csv' => 'No se pudo abrir el archivo CSV.']);
            }

            // Skip the header row
            fgetcsv($handle);

            $chunkSize = 25;
            $totalRows = 0;
            $totalAssigned = 0;
            
            while (!feof($handle)) {
                $chunk = [];

                for ($i = 0; $i < $chunkSize; $i++) {
                    $data = fgetcsv($handle);
                    if ($data === false) {
                        break;
                    }
                    $chunk[] = $data;
                }

                if (!empty($chunk)) {
                    $assigned = $this->importChunkData($chunk, $exchange);
                    $totalRows += count($chunk);
                    $totalAssigned += $assigned;
                }
            }
            fclose($handle);

            return back()->with('success', "Sucesfully imported users");

        } catch (\Exception $e) {
            return back()->withErrors(['import_csv' => 'Error al importar: ' . $e->getMessage()]);
        }
    }

    public function show(Exchange $exchange, User $addUser)
    {
        $isLinked = $exchange->users()->whereKey($addUser->id)->exists();

        if (!$isLinked) {
            abort(404);
        }

        return response()->json([
            'exchange_id' => $exchange->id,
            'user' => $addUser,
        ]);
    }

    private function importChunkData(array $chunkData, Exchange $exchange): int
    {
        $assignedCount = 0;

        foreach ($chunkData as $row) {
            try {
                $firstName = trim($row[0] ?? '');
                $lastName = trim($row[1] ?? '');
                $email = trim($row[2] ?? '');

                if (empty($firstName) || empty($email)) {
                    continue;
                }

                // Validar email
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    continue;
                }

                $user = User::updateOrCreate(
                    ['email' => $email],
                    [
                        'name' => $firstName,
                        'surname' => $lastName,
                        'email' => $email,
                        'role' => 'student',
                        'password' => Hash::make(Str::random(32)),
                    ]
                );

                $existingLink = $exchange->users()->whereKey($user->id)->exists();
                $exchange->users()->syncWithoutDetaching([$user->id]);
                if (!$existingLink) {
                    $assignedCount++;
                }
            } catch (\Exception $e) {
                \Log::warning('Error importing user: ' . $e->getMessage());
                continue;
            }
        }

        return $assignedCount;
    }
}
