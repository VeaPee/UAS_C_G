<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use Illuminate\Http\Request;

use App\Http\Resources\TournamentResource;
use Illuminate\Support\Facades\Validator;

class TournamentController extends Controller
{
    public function index()
    {
        $tournament = Tournament::latest()->get();
        //render view with posts
        return new TournamentResource(true, 'List Data Tournament', $tournament);
    }

    public function show($id)
    {
        //find post by ID
        $tournament = Tournament::findOrfail($id);

        return new TournamentResource(true, 'Detail Data', $tournament);

    }

    public function store(Request $request)
    {
        //Validasi Formulir
        $validator = Validator::make($request->all(), [
            'nama_tournament' => 'required',
            'tanggal_tournament' => 'required',
            'prizepool' => 'required',
            'totalTeam' => 'required',
            'id_team'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        //Fungsi Post ke Database
        $tournament = Tournament::create([
            'nama_tournament' => $request->nama_tournament,
            'tanggal_tournament' => $request->tanggal_tournament,
            'prizepool' => $request->prizepool,
            'totalTeam' => $request->totalTeam,
            'id_team' => $request->id_team
        ]);
        return new TournamentResource(true, 'Data tournament Berhasil Ditambahkan!', $tournament);
    }

    public function update(Request $request, Tournament $tournament)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'nama_tournament' => 'required',
            'tanggal_tournament' => 'required',
            'prizepool' => 'required',
            'totalTeam' => 'required',
            'id_team'
        ]);
        
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //find tournament by ID
        $tournament = Tournament::findOrFail($tournament->id);

        if($tournament) {

            //tournament post
            $tournament->update([
                'nama_tournament' => $request->nama_tournament,
                'tanggal_tournament' => $request->tanggal_tournament,
                'prizepool' => $request->prizepool,
                'totalTeam' => $request->totalTeam,
                'id_team' => $request->id_team
            ]);

            return new TournamentResource(true, 'Data tournament Berhasil Diubah!', $tournament);

        }

        //data tournament not found
        return new TournamentResource(false, 'Data tournament Tidak Ditemukan!', $tournament);

    }
    
    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {
        //find tournament by ID
        $tournament = Tournament::findOrfail($id);

        if($tournament) {

            //delete tournament
            $tournament->delete();

            return new TournamentResource(true, 'Data tournament Dihapus!', $tournament);

        }

        //data tournament not found
        return new TournamentResource(false, 'Data tournament Tidak Ditemukan!', $tournament);
    }
}
