<?php

namespace Dashboard\Http\Controllers;

use Redirect;
use Dashboard\Http\Requests;

use Dashboard\Article;
use Dashboard\Category;
use Dashboard\Form;
use Dashboard\Node;
use Dashboard\Webdocs;
use Dashboard\SyncArticleSP;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use Carbon\Carbon;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($nodeId)
    {

        $node = Node::where('node', $nodeId)->first();
        $forms = Form::findByNode($nodeId)->sortBy('article_title', SORT_NATURAL|SORT_FLAG_CASE);

        $isGroupCode = $forms->sum(function ($groups) {
            return (count($groups['group_cd']));
        });

        $files = Webdocs::findByNode($nodeId);

        $articleCollection = collect([]);

        foreach ($forms as $form) {

            $begin_date = $form['begin_date'] ? (new Carbon($form['begin_date']))->format('m/d/Y') : null;
            $end_date = $form['end_date'] ? (new Carbon($form['end_date']))->format('m/d/Y') : null;

            $newArray = [
                'id'         => $form['id'],
                'name'       => $form['article_title'],
                'db'         => true,
                'file'       => $this->isInFilelist($form['article_link'], $files), // create method to check if filename is in the FileList & remove from FileList
                'active'     => 'Y' == $form['active_yn'],
                'filename'   => $form['article_link'],
                'section'    => $form['article_section'],
                'title'      => $form['article_title'],
                'text'       => $form['article_text'],
                'content'    => $form['article_content'],
                'groupcd'    => $form['group_cd'],
                'modified'   => new Carbon(substr($form['last_modified'], 0, 10)),
                'category'   => $form['article_category'],
                'categoryId' => Category::findCategoryValue($form['article_category']),
                'begin_date' => $begin_date,
                'end_date'   => $end_date,
            ];

            $articleCollection->push(new Article($newArray));
        }

        foreach ($files as $file) {
            $newArray = [
                'id'         => null,
                'name'       => null,
                'db'         => false,
                'file'       => true,
                'active'     => false,
                'filename'   => $file,
                'section'    => 'FORMS',
                'title'      => null,
                'text'       => null,
                'content'    => null,
                'groupcd'    => null,
                'modified'   => Carbon::now(),
                'category'   => null,
                'categoryId' => null,
                'begin_date' => null,
                'end_date'   => null,
            ];

            $articleCollection->push(new Article($newArray));
        }

        // dd($forms, $articleCollection);

        $section = 'forms';
        $files = $articleCollection->pluck('filename')->all();
        $categories = Category::orderBy('id')->get();

        return view('forms.index', compact('node', 'articleCollection', 'files', 'isGroupCode', 'section', 'categories'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($nodeId)
    {
        $node = Node::where('node', $nodeId)->first();
        $files = Webdocs::findByNode($nodeId);

        return view('forms.create', compact('node', 'files'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd("Storing file");

        $file = $request->file('getfile');
        $filename = $request->article_link;

        Form::insertRecord($request);
        return Redirect::route('nodes.forms.index', [$request->node]);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $nodeId
     * @param  int  $id
     * @return Downloads a linked PDF document
     */
    public function show($nodeId, $id)
    {
        $form = Form::findById($nodeId, $id);

        $node = ('CON' == $form->node) ? 'COND' : $form->node;

        header('Content-Description: File Transfer');
        header('Content-type: application/pdf');
        header('Content-Disposition: attachment; filename=' . $form->article_link);
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize('/mnt/WebDocs/' . $node . '/' . $form->article_link));
        ob_clean();

        flush();

        readfile('/mnt/WebDocs/' . $node . '/' . $form->article_link);

        exit;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($nodeId, $id)
    {
        $node = Node::where('node', $nodeId)->first();
        $form = Form::findById($nodeId, $id);
        $files = Webdocs::findByNode($nodeId);

        return view('forms.edit', compact('node', 'form', 'files'));
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
        // dd($request);
        Form::updateRecord($request, $id);
        return Redirect::route('nodes.forms.index', [$request->node]);
    }

    /**
     * Update the LIVE DB with the TEST.
     *
     * @param string $node
     * @param  int  $section - Article Section ie: FORMS, LINKS, NEWS
     * @return \Illuminate\Http\Response
     */
    public function sync(Request $request)
    {

        $result = SyncArticleSP::sync($request->node, $request->section);

        return response()->json(['result' => $result]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        dd("form destroy");
    }

    private function isInFilelist($filename, &$filelist)
    {
        if (in_array($filename, $filelist)) {
            $filelist = array_diff($filelist, array($filename));
            // unset($filelist[array_search($filename, $filelist)]);
            return true;
        } else {
            return false;
        }
    }
}
