<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = Job::latest()->with(['employer','tags'])->get()->groupBy('featured');
        return view("jobs.index",[
            "featuredJobs"=> $jobs[1],
            'jobs'=> $jobs[0],
            'tags' => Tag::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attrs = $request->validate([
            'title'=> 'required',
            'salary'=> 'required',
            'location'=> 'required',
            'schedule' => ['required',Rule::in(['Full Time','Part Time'])],
            'url' => ['required', 'active_url'],
            'tags' => ['nullable']
        ]);

        $attrs['featured'] = $request->has('featured');

        $job = Auth::user()->employer->jobs()->create(Arr::except($attrs, 'tags'));

        if ($attrs['tags'] ?? false) {
            foreach(explode(',', $attrs['tags']) as $tag){
                // dd($tag);
                $job->tag($tag);
        }};
        return redirect('/');
    }
}
