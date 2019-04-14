<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //模型关联的数据表
    public $table = 'admin_user';
    // 主键
    public $primaryKey = 'user_id';
    // 是否维护created_at updated_at字段
    public $timstamps = false;
    // 是否允许批量操作字段
    public $guarded = [];
}
