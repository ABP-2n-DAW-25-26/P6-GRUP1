<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class addUsersController extends Controller
{
    public function index()
    {

    }

    public function create()
    {
        return inertia('teacher/AddUsers');
    }

    public function importCSV(Request $request)
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
                    $this->importChunkData($chunk);
                    $totalRows += count($chunk);
                }
            }
            fclose($handle);

            return redirect()->route('users.index')->with('success', "Se importaron {$totalRows} usuarios correctamente.");
            
        } catch (\Exception $e) {
            return back()->withErrors(['import_csv' => 'Error al importar: ' . $e->getMessage()]);
        }
    }

    public function importChunkData($chunkData)
    {
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

                User::updateOrCreate(
                    ['email' => $email],
                    [
                        'name' => $firstName,
                        'surname' => $lastName,
                        'email' => $email,
                        'role' => 'student',
                        'password' => bcrypt(random_bytes(16)),
                    ]
                );
            } catch (\Exception $e) {
                \Log::warning('Error importing user: ' . $e->getMessage());
                continue;
            }
        }
    }
}
