<?php

namespace App\Http\Controllers;

use App\Models\JobVacancy;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = JobVacancy::query();

        // query of type (priority)
        if($request->filled('type') && $request->type !== 'all_jobs'){
            $query->where('type' , $request->type);
        }

        // query of search
        if($request->filled('search')){
            $query->where(function($query) use ($request){
                $query->where('title' , 'like' , '%' . $request->search . '%')
                ->orWhere('location' , 'like' , '%' . $request->search . '%')
                ->orWhereHas('jobCategory', function($query) use($request){
                    $query->where('name' , 'like' , '%' . $request->search . '%');
                })
                ->orWhereHas('company' , function($query) use($request){
                    $query->where('name' , 'like' , '%' . $request->search . '%');
                });
            });
        }

        $jobs = $query->latest()->paginate(10)->withQueryString();

        return view('dashboard.index', compact('jobs'));
    }
}
