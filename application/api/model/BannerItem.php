<?php

namespace app\api\model;

use think\Model;

//Terminal命令：D:\Dev\MySite\imp>php think make:model api/BannerItem

class BannerItem extends BaseModel
{
    protected $hidden = ['id','img_id','banner_id','update_time','delete_time'];
    public function img(){
        return $this->belongsTo('Image','img_id','id');//后面两个可以省，但建议写完整
    }

}
