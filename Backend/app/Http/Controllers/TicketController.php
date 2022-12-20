<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiTicket;
use App\Http\Resources\TicketResource;
use Illuminate\Support\Facades\Validator;
class TicketController extends Controller
{
    public function index()
    {
        $ticket = TransaksiTicket::latest()->get();
        //render view with posts
        return new TicketResource(true, 'List Data ticket', $ticket);
    }

    public function show($id)
    {
        //find post by ID
        $ticket = TransaksiTicket::findOrfail($id);

        return new TicketResource(true, 'Detail Data', $ticket);

    }

    public function store(Request $request)
    {
        //Validasi Formulir
        $validator = Validator::make($request->all(), [
            'namaTournament' => 'required',
            'hargaTicket' => 'required',
            'tempatDuduk' => 'required',
            'jenisTicket' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        //Fungsi Post ke Database
        $ticket = TransaksiTicket::create([
            'namaTournament' => $request->namaTournament,
            'hargaTicket' => $request->hargaTicket,
            'tempatDuduk' => $request->tempatDuduk,
            'jenisTicket' => $request->jenisTicket,
        ]);
        return new TicketResource(true, 'Data ticket Berhasil Ditambahkan!', $ticket);
    }

    public function update(Request $request, TransaksiTicket $ticket)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'namaTournament' => 'required',
            'hargaTicket' => 'required',
            'tempatDuduk' => 'required',
            'jenisTicket' => 'required'
        ]);
        
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //find ticket by ID
        $ticket = TransaksiTicket::findOrFail($ticket->id);

        if($ticket) {

            //ticket post
            $ticket->update([
                'namaTournament' => $request->namaTournament,
                'hargaTicket' => $request->hargaTicket,
                'tempatDuduk' => $request->tempatDuduk,
                'jenisTicket' => $request->jenisTicket
            ]);

            return new TicketResource(true, 'Data ticket Berhasil Diubah!', $ticket);

        }

        //data ticket not found
        return new TicketResource(false, 'Data ticket Tidak Ditemukan!', $ticket);

    }
    
    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {
        //find ticket by ID
        $ticket = TransaksiTicket::findOrfail($id);

        if($ticket) {

            //delete ticket
            $ticket->delete();

            return new TicketResource(true, 'Data ticket Dihapus!', $ticket);

        }

        //data ticket not found
        return new TicketResource(false, 'Data ticket Tidak Ditemukan!', $ticket);
    }
}
