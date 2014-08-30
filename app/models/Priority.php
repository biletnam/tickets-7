<?php

class Priority extends \Eloquent {
	protected $fillable = [];
    protected $table="priorities";

    public function scopeStatusList($query)
    {
        return $query->select('title','description','id')->orderBy('order');
    }

    public static function arrayPriority()
    {
        $arResult=array();
        foreach(Priority::StatusList()->get() as $item){
            $arResult[] = $item;
        }
        return $arResult;
    }
}