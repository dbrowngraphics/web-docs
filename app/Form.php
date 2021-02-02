<?php

namespace Dashboard;

use DB;

use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use Carbon\Carbon;

class Form extends Model
{
    protected $table = 'CW.V3T_GET_ARTICLES';

    public static function findByNode($node)
    {
        DB::statement("BEGIN CW.V3P_GET_ARTICLES_ID(:p_node, :p_group_cd, :p_article_group, :p_section, :p_article_id); END;",
            ['p_node' => $node, 'p_group_cd' => '*', 'p_article_group' => '', 'p_section' => 'FORMS', 'p_article_id' => '*']);

        return self::all();
    }

    public static function findById($node, $id)
    {
        DB::statement("BEGIN CW.V3P_GET_ARTICLES_ID(:p_node, :p_group_cd, :p_article_group, :p_site_section, :p_article_id); END;",
            ['p_node' => $node, 'p_group_cd' => '*', 'p_article_group' => '', 'p_site_section' => 'FORMS', 'p_article_id' => $id]);

        return self::first();
    }

    public static function insertRecord(Request $request)
    {

        $node = $request->node;
        $filename = ('' == $request->article_link) ? $file->getClientOriginalName : $request->article_link;

        $file = $request->file('getfile');
        if ($file) {
            Form::uploadFile($node, $file, $filename);
        }

        $date_begin = '';
        if(isset($request->article_begindate)) {
            $begin_date = (new Carbon($request->article_begindate))->format('d-M-Y');
            $date_begin = date('d-M-Y', strtotime($request->article_begindate));
        }

        $date_end = '';
        if(isset($request->article_enddate)) {
            $end_date = (new Carbon($request->article_enddate))->format('d-M-Y');
            $date_end = date('d-M-Y', strtotime($request->article_enddate));
        }

        $category = '0';
        if (isset($request->article_category)) {
            if (!('hidden' == $request->article_category) && !('' == $request->article_category)) {
                $category = $request->article_category;
            }
        }

        DB::setDateFormat('DD-MON-YYYY');
        DB::statement("BEGIN cw.v3p_insert_articles(:p_node, :p_group_cd, :p_section, :p_active, :p_link, :p_text, :p_title, :p_content, :p_category, :p_begin_date, :p_end_date); END; ",
            [
                'p_node'       => $node,
                'p_group_cd'   => $request->group_cd,
                // 'p_section' => $request->article_section,
                'p_section'    => 'FORMS',
                'p_active'     => $request->article_active ? 'Y' : 'N',
                'p_link'       => $filename,
                'p_text'       => $request->article_text,
                'p_title'      => $request->article_title,
                'p_content'    => $request->article_content,
                'p_category'   => $category,
                'p_begin_date' => $date_begin,
                'p_end_date'   => $date_end,
            ]);

    }

    public static function updateRecord(Request $request, $id)
    {

        $date_begin = '';
        if(isset($request->article_begindate)) {
            $begin_date = (new Carbon($request->article_begindate))->format('d-M-Y');
            $date_begin = date('d-M-Y', strtotime($request->article_begindate));
        }

        $date_end = '';
        if(isset($request->article_enddate)) {
            $end_date = (new Carbon($request->article_enddate))->format('d-M-Y');
            $date_end = date('d-M-Y', strtotime($request->article_enddate));
        }

        $category = '0';
        if (isset($request->article_category)) {
            if (!('hidden' == $request->article_category) && !('' == $request->article_category)) {
                $category = $request->article_category;
            }
        }

        $node = $request->node;
        $filename = ('' == $request->article_link) ? $file->getClientOriginalName : $request->article_link;
        $file = $request->file('getfile');

        if ($file) {
            Form::uploadFile($node, $file, $filename);
        }

        // dd($request);

        DB::setDateFormat('DD-MON-YYYY');
        DB::statement("BEGIN cw.v3p_update_articles(:p_id, :p_node, :p_group_cd, :p_section, :p_active, :p_link, :p_text, :p_title, :p_content, :p_category, :p_begin_date, :p_end_date); END; ",
            [
                'p_id'         => $id,
                'p_node'       => $request->node,
                'p_group_cd'   => $request->group_cd,
                'p_section'    => $request->article_section,
                'p_active'     => $request->article_active ? 'Y' : 'N',
                'p_link'       => $request->article_link,
                'p_text'       => $request->article_text,
                'p_title'      => $request->article_title,
                'p_content'    => $request->article_content,
                'p_category'   => $category,
                'p_begin_date' => $date_begin,
                'p_end_date'   => $date_end,
            ]);
    }


    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'node';
    }

    /**
     * $path is only needed when viewing on LOCAL, remove for Online
     */
    private static function uploadFile($node, $file, $filename)
    {
        // dd($_FILES['getfile']['tmp_name']);

        // $path = public_path();
        // $file_path = $path . '/mnt/WebDocs/DDB/';

        $node = ('CON' == $node) ? 'COND' : $node;

        $file_path = '/mnt/WebDocs/' . $node . '/';

        $file->move($file_path, $filename);

        // dd(move_uploaded_file($_FILES['getfile']['tmp_name'], $file_path));
    }

    private static function changeFilename()
    {
        // Get file based on ID
        // Update filename to new filename
    }
}
