<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function index()
    {
        $applications = JobApplication::where('user_id',Auth::user()->id)
        ->latest()->paginate(5);

        return view('application.index',compact('applications'));
    }
}
