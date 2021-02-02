<?php

namespace Dashboard;

use DB;

use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Tool extends Model
{
    protected $table = 'CW.V3T_GET_ARTICLES';

    public static function findByNode($node)
    {
        DB::statement("BEGIN CW.V3P_GET_ARTICLES_ID(:p_node, :p_group_cd, :p_article_group, :p_site_section, :p_article_id); END;",
            ['p_node' => $node, 'p_group_cd' => '*', 'p_article_group' => '', 'p_site_section' => 'TOOLS', 'p_article_id' => '*']);

        return self::all();
    }

    public static function findById($node, $id)
    {
        DB::statement("BEGIN CW.V3P_GET_ARTICLES_ID(:p_node, :p_group_cd, :p_article_group, :p_site_section, :p_article_id); END;",
            ['p_node' => $node, 'p_group_cd' => '*', 'p_article_group' => '', 'p_site_section' => 'TOOLS', 'p_article_id' => $id]);

        return self::first();
    }

    public static function insertRecord(Request $request)
    {
        $node = $request->node;

        DB::statement("BEGIN cw.v3p_insert_articles(:p_node, :p_group_cd, :p_section, :p_active, :p_link, :p_text, :p_title, :p_content); END; ",
            [
                'p_node'     => $node,
                'p_group_cd' => $request->group_cd,
                // 'p_section'  => $request->article_section,
                'p_section'  => 'TOOLS',
                'p_active'   => $request->article_active ? 'Y' : 'N',
                'p_link'     => $request->article_link,
                'p_text'     => $request->article_text,
                'p_title'    => $request->article_title,
                'p_content'  => $request->article_content
            ]);

    }

    public static function updateRecord(Request $request, $id)
    {
        DB::statement("BEGIN cw.v3p_update_articles(:p_id, :p_node, :p_group_cd, :p_section, :p_active, :p_link, :p_text, :p_title, :p_content); END; ",
            [
                'p_id'       => $id,
                'p_node'     => $request->node,
                'p_group_cd' => $request->group_cd,
                'p_section'  => $request->article_section,
                'p_active'   => $request->article_active ? 'Y' : 'N',
                'p_link'     => $request->article_link,
                'p_text'     => $request->article_text,
                'p_title'    => $request->article_title,
                'p_content'  => $request->article_content
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
}
