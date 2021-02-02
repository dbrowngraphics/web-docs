<?php

namespace Dashboard;

use Illuminate\Database\Eloquent\Model;

class Node extends Model
{
    protected $table = 'CW.V3T_NODE';

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
     * Get the node & name pair.
     *
     * @return string
     */
    public static function getNodeAndName()
    {
        // dd(self::orderBy('node')->get(['node', 'node_name'])->all());
        // dd(self::orderBy('node')->get(['node', 'node_name'])->pluck('node_name', 'node'));
        // dd(self::orderBy('node')->get(['node', 'node_name'])->lists('node_name', 'node'));

        $nodes = self::orderBy('node')->get(['node', 'node_name'])->all();
        $nodeList = [];
        foreach ($nodes as $node) {
            array_push($nodeList, "" . $node->node . " - " . str_limit($node->node_name, 30));
        }
        return $nodeList;
    }
}
