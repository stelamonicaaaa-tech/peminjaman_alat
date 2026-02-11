<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogAktivitasController extends Controller
{
    public function index()
    {
        $query = LogAktivitas::with('user')->latest();

        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized access');
        }

        $logAktivitas = $query->paginate(10);

        return view('logAktivitas.index', compact('logAktivitas'));
    }
}
