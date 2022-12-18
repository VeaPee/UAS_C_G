<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

use App\Http\Resources\TeamResource;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    public function index()
    {
        $team = Team::latest()->get();
        //render view with posts
        return new TeamResource(true, 'List Data Team', $team);
    }

    public function show($id)
    {
        //find post by ID
        $team = Team::findOrfail($id);

        return new TeamResource(true, 'Detail Data', $team);

    }

    public function store(Request $request)
    {
        //Validasi Formulir
        $validator = Validator::make($request->all(), [
            'nama_tim' => 'required',
            'kota' => 'required',
            'pelatih' => 'required',
            'analis' =>  'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        //Fungsi Post ke Database
        $team = Team::create([
            'nama_tim' => $request->nama_tim,
            'kota' => $request->kota,
            'pelatih' => $request->pelatih,
            'analis' => $request->analis
        ]);
        return new TeamResource(true, 'Data team Berhasil Ditambahkan!', $team);
    }

    public function update(Request $request, team $team)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'nama_tim' => 'required',
            'kota' => 'required',
            'pelatih' => 'required',
            'analis' =>  'required'
        ]);
        
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //find team by ID
        $team = team::findOrFail($team->id);

        if($team) {

            //team post
            $team->update([
                'nama_tim' => $request->nama_tim,
                'kota' => $request->kota,
                'pelatih' => $request->pelatih,
                'analis' => $request->analis
            ]);

            return new teamResource(true, 'Data team Berhasil Diubah!', $team);

        }

        //data team not found
        return new teamResource(false, 'Data team Tidak Ditemukan!', $team);

    }
    
    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {
        //find team by ID
        $team = team::findOrfail($id);

        if($team) {

            //delete team
            $team->delete();

            return new TeamResource(true, 'Data team Dihapus!', $team);

        }

        //data team not found
        return new TeamResource(false, 'Data team Tidak Ditemukan!', $team);
    }
}
