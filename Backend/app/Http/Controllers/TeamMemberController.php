<?php

namespace App\Http\Controllers;

use App\Http\Resources\TeamMemberResource;
use App\Models\TeamMember;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;


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
            'id_game' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $teamMember = TeamMember::create([
            'member_name' => $request -> member_name,
            'id_game' => $request -> id_game
        ]);
        return new TeamMemberResource(true, "Data Team Member Berhasil Ditambahkan!", $teamMember);
    }

     /** update
     *
     * @param  mixed $request
     * @param  mixed $post
     * @return void
     */

    public function update(Request $request, TeamMember $teamMember)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'member_name' => 'required',
            'id_game' => 'required|numeric',
        ]);
        
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //find team by ID
        $teamMember = TeamMember::findOrFail($teamMember->id);

        if($teamMember) {

            //team post
            $teamMember->update([
                'member_name' => $request->member_name,
                'id_game' => $request->id_game
            ]);

            return new TeamMemberResource(true, 'Data Team Member Berhasil Diubah!', $teamMember);

        }

        //data team not found
        return new TeamMemberResource(false, 'Data Team Member Tidak Ditemukan!', $teamMember);

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
