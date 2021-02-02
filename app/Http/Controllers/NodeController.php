<?php

namespace Dashboard\Http\Controllers;

use Illuminate\Http\Request;

use Dashboard\Http\Requests;

use Dashboard\Node;

class NodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $node_list = Node::pluck('node', 'node')->unique()->sort();
        // $nodes = Node::all();
        return view('nodes.index', compact('node_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd("node create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd("node store", $request);

        $nodeId = strtoupper($request->node_id);
        return redirect()->action('NodeController@show', ['nodeId' => $nodeId]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($nodeId)
    {
        // dd($node);
        // dd('Node Show');

        $node = Node::where('node', $nodeId)->first();

        if ('CON' == $node) {
            $node = 'COND';
        }

        return view('nodes.show', compact('node'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        dd("node edit");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        dd("node update");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        dd("node destroy");
    }

    public function nodeFilter(Request $request)
    {
        $nodeId = strtoupper($request->node_id);
        // $node = Node::where('node', $nodeId)->first();

        // if (! $node) {
        //     return view('No Results');
        // }

        // dd("Die & Dump");

        return redirect()->action('NodeController@show', ['nodeId' => $nodeId]);
        // return $this->show($node);

    }
}
