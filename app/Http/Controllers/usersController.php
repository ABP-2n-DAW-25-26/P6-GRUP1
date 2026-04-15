<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class usersController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function importCSV(Request $request)
    {
        $request->validate([
            'import_csv' => 'required|mimes:csv,txt',
        ]);
        // Read csv file and skip data
        $file = $request->file('import_csv');
        $handle = fopen($file, 'r');

        // Skip the header row
        fgetcsv($handle);

        $chunksize = 25;
        while(!feof($handle))
            {
                $chunksize = [];

                for($i = 0; $i<$chunksize; $i++)
                    {
                        $data = fgetcsv($handle);
                        if($data === false)
                        {
                            break;
                        }
                        $chunksize[] = $data;
                    }
                $this->getchunkdata($chunkdata);
            }
        fclose($handle);

        return redirect()->route('users.create')->with('success', 'CSV imported successfully.');
    }

    public function getchunkdata($chunkdata)
    {
        foreach($chunkdata as $column)
            {
                $fistname = $column[0];
                $lastname = $column[1];
                $email = $column[2];
                $type = "student";
            }

            $user = new User();
            $user->name = $fistname;
            $user->surname = $lastname;
            $user->email = $email;
            $user->role = $type;
            $user->save();
    }
}

    // public function addUsers(Request $request)
    // {
    //     $users = $request->input('users');
    //     $exchangeId = $request->input('exchange_id');


    //     return response()->json(['message' => 'Usuarios agregados correctamente']);
    // }

    // public function removeUsers(Request $request)
    // {
    //     $users = $request->input('users');
    //     $exchangeId = $request->input('exchange_id');
    //     return response()->json(['message' => 'Usuarios eliminados correctamente']);
    // }
}
