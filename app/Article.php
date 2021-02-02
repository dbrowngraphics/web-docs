<?php

namespace Dashboard;

use Carbon\Carbon;

class Article
{
    public $id;
    public $active;
    public $title;
    public $name;
    public $db;
    public $file;
    public $filename;
    public $section;
    public $text;
    public $content;
    public $groupcd;
    public $modified;
    public $category;
    public $categoryId;
    public $oldFile;
    public $beginDate;
    public $endDate;

    public function __construct($articleInfo)
    {
        $this->id         = $articleInfo['id'];
        $this->name       = $articleInfo['name'];
        $this->db         = $articleInfo['db'];
        $this->file       = $articleInfo['file'];
        $this->active     = $articleInfo['active'];
        $this->filename   = $articleInfo['filename'];
        $this->section    = $articleInfo['section'];
        $this->title      = $articleInfo['title'];
        $this->text       = $articleInfo['text'];
        $this->content    = $articleInfo['content'];
        $this->groupcd    = $articleInfo['groupcd'];
        $this->modified   = $articleInfo['modified']->format('m/d/Y');
        $this->category   = $articleInfo['category'];
        $this->categoryId = $articleInfo['categoryId'];
        $this->oldFile    = $articleInfo['modified']->diffInDays(Carbon::now()) > 365;
        $this->beginDate  = $articleInfo['begin_date'];
        $this->endDate    = $articleInfo['end_date'];
    }
}
