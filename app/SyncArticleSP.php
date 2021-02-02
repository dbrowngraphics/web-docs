<?php
/**
 * Created by PhpStorm.
 * User: ddb
 * Date: 11/19/2018
 * Time: 10:51 AM
 */

namespace Dashboard;

use DB;

use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;


class SyncArticleSP extends Model
{
    public static function sync($node, $section)
    {

        $result = 'N';
        $pdo = DB::connection()->getPdo();
        $stmt = $pdo->prepare("BEGIN CW.V3U_CLONE_ARTICLES(:p_node, :p_section, :p_result); END;");

        $stmt->bindParam(':p_node', $node);
        $stmt->bindParam(':p_section', $section);
        $stmt->bindParam(':p_result', $result, $pdo::PARAM_INPUT_OUTPUT, 8);
        $stmt->execute();

        return $result;
    }
}