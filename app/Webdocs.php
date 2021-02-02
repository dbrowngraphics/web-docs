<?php

namespace Dashboard;

class Webdocs
{
    /**
     * $path is only needed for local development
     */
    public static function findByNode($node)
    {
        // $path = public_path();
        // $dir = $path . '/mnt/WebDocs/DDB';

        if ('CON' == $node) {
            $node = 'COND';
        }

        $dir = '/mnt/WebDocs/' . $node;

        if (! file_exists($dir)) {
            if (! mkdir($dir)) {
                // Throw an error & contact IT. Directory was not created.
                dd('The directory was not created');
            }
        }

        $fileDir = scandir($dir);
        $fileList = array_diff($fileDir, array('.', '..'));

        return $fileList;
    }
}