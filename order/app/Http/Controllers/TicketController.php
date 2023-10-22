<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::get();

        return response([
            'status' => 200,
            'data' => $tickets
        ], 200);
    }
}
