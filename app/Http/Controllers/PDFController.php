<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use PDF;

class PDFController extends Controller
{
    public function generatePDF()
    {
        $users = User::get();
        $data = [
            'title' => 'Welcome to ItSolutionStuff.com',
            'date' => date('m/d/Y'),
            'users' => $users
        ]; 
        $pdf = PDF::loadView('pdf.example', $data);
        return $pdf->download('itsolutionstuff.pdf');

    }
}
