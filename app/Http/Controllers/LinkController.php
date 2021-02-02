<?php

namespace Dashboard\Http\Controllers;

use Redirect;
use Dashboard\Http\Requests;

use Dashboard\Article;
use Dashboard\Link;
use Dashboard\Node;
use Dashboard\Webdocs;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use Carbon\Carbon;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($nodeId)
    {
        $node = Node::where ('node', $nodeId)->first();
        $links = Link::findByNode($nodeId)->sortBy('article_title', SORT_NATURAL|SORT_FLAG_CASE);

        $isGroupCode = $links->sum(function ($groups) {
            return (count($groups['group_cd']));
        });

        $articleCollection = collect([]);

        foreach ($links as $link) {
            $newArray = [
                'id'       => $link['id'],
                'name'     => $link['article_title'],
                'db'       => true,
                'file'     => false,
                'active'   => 'Y' == $link['active_yn'],
                'filename' => $link['article_link'],
                'section'  => $link['article_section'],
                'title'    => $link['article_title'],
                'text'     => $link['article_text'],
                'content'  => $link['article_content'],
                'groupcd'  => $link['group_cd'],
                'modified' =>  new Carbon(substr($link['last_modified'], 0, 10)),
            ];

            $articleCollection->push(new Article($newArray));
        }

        $section = 'links';
        return view('links.index', compact('node', 'articleCollection', 'isGroupCode', 'section'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd('Links create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd('Links store');

        Link::insertRecord($request);
        return Redirect::route('nodes.links.index', [$request->node]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd('Links show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        dd('Links edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $nodeId, $id)
    {
        // dd('Links update');
        Link::updateRecord($request, $id);
        return Redirect::route('nodes.links.index', [$request->node]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
