<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 2019/9/30
 * Time: 20:37
 */

namespace app\api\model;


use think\console\command\make\Model;
use think\Db;

class Pjaauc_t extends t100Model
{
//    protected $table = 'pjaauc_t';
//
//    protected $visible = [];
    protected $hidden = ['pjaauc002','pjaauc003'];
}