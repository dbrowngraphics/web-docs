<?php

namespace Dashboard\Http\Controllers;

use Redirect;
use Dashboard\Http\Requests;

use Dashboard\Article;
use Dashboard\Node;
use Dashboard\Tool;
use Dashboard\Webdocs;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use Carbon\Carbon;


class ToolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($nodeId)
    {
        $node = Node::where ('node', $nodeId)->first();
        $tools = Tool::findByNode($nodeId)->sortBy('article_title', SORT_NATURAL|SORT_FLAG_CASE);

        $isGroupCode = $tools->sum(function ($groups) {
            return (count($groups['group_cd']));
        });

        $articleCollection = collect([]);

        foreach ($tools as $tool) {
            $newArray = [
                'id'       => $tool['id'],
                'name'     => $tool['article_title'],
                'db'       => true,
                'file'     => false,
                'active'   => 'Y' == $tool['active_yn'],
                'filename' => $tool['article_link'],
                'section'  => $tool['article_section'],
                'title'    => $tool['article_title'],
                'text'     => $tool['article_text'],
                'content'  => $tool['article_content'],
                'groupcd'  => $tool['group_cd'],
                'modified' =>  new Carbon(substr($tool['last_modified'], 0, 10)),
            ];

            $articleCollection->push(new Article($newArray));
        }

        $section = 'tools';
        return view('tools.index', compact('node', 'articleCollection', 'isGroupCode', 'section'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
