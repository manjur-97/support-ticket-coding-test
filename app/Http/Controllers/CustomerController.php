<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $tickets=Ticket::where('customer_id', auth()->id())->with('customer')->get();
        return view('customer.index', compact('tickets'));
    }

   
}
