<?php

namespace App\Http\Controllers;

use App\Models\Cluster;
use Illuminate\Http\Request;

class ClusterController extends Controller
{
    public function index(){
        $cluster = Cluster::all();
        return view('pages.cluster.index', ['cluster' => $cluster]);
    }

    public function create(){
        $cluster = Cluster::all();
        return view('pages.cluster.create', ['cluster' => $cluster]);
    }

    public function store(Request $request){
        $cluster = new Cluster();
        $cluster-> name = $request-> name;

        $cluster->save();

        if ($cluster) {
            return redirect()
                ->route('cluster')
                ->with([
                    'success' => 'New post has been created successfully'
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Some problem occurred, please try again'
                ]);
        }
    }

    public function edit($id){
        $cluster = Cluster::find($id);
        return response()->json($cluster);
    }

    public function update(Request $request){
        $cluster = Cluster::find($request->cluster_id);
        $cluster->name = $request->name;
        $cluster->save();
        return redirect('/cluster');
    }
}
