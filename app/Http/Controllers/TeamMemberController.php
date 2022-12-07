<?php

namespace App\Http\Controllers;

use App\Http\Resources\TeamMemberResource;
use App\Models\TeamMember;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Team;


class TeamMemberController extends Controller
{
    public function index()
    {
        $teamMember = TeamMember::latest()->get();
        //render view with posts
        return new TeamMemberResource(true, 'List Data Team Member', $teamMember);
    }

    public function show($id)
    {
        //find post by ID
        $teamMember = TeamMember::findOrfail($id);

        return new TeamMemberResource(true, 'Detail Data', $teamMember);

    }

    public function store(Request $request)
    {
        //Validasi Formulir
        $validator = Validator::make($request->all(), [
            'member_name' => 'required',
            'id_game' => 'required|numeric|max:10',
            'id_team' => 'required|numeric|max:7',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $team = Team::where('nama_tim', $request->id_team)->first();

        $teamMember = TeamMember::create([
            'member_name' => $request -> member_name,
            'id_game' => $request -> id_game,
            'id_team' => $team-> id,
        ]);
        return new TeamMemberResource(true, "Data Team Member Berhasil Ditambahkan!", $teamMember);
    }

    public function edit($id)
    {
        $teamMember = TeamMember::findOrFail($id);
        return view('teamMember.edit', compact('teamMember'));
    }

     /** update
     *
     * @param  mixed $request
     * @param  mixed $post
     * @return void
     */

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'member_name' => 'required',
            'id_game' => 'required|numeric|max:10',
            'id_team' => 'required|numeric|max:7',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $teamMember = TeamMember::findOrFail($id);
        $team = Team::where('member_name', $request->id_team) -> first();
        $teamMember->update([
            'member_name' => $request->member_name,
            'id_game' => $request->id_game,
            'id_team'=> $team->id
        ]);
        return new TeamMemberResource(true, "Data Team Member Berhasil Diubah!", $teamMember);
    }

    public function destroy($id)
    {
        //find team by ID
        $teamMember = TeamMember::findOrfail($id);

        if($teamMember) {

            //delete team
            $teamMember->delete();

            return new TeamMemberResource(true, 'Data team Dihapus!', $teamMember);

        }

        //data team not found
        return new TeamMemberResource(false, 'Data team Tidak Ditemukan!', $teamMember);
    }

}
