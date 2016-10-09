<?php

namespace App\Models\Admin;

use App\Models\Power\MenuGroup;
use App\Models\Power\Role;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Power\Menu;
class Entity extends Model implements \Illuminate\Contracts\Auth\Authenticatable
{
    use Authenticatable;

    public static $_RULES = [//验证规则
        'nickname' => 'required|between:2,25|unique:admin', //varchar(32) DEFAULT NULL COMMENT '真实姓名'
        'username' => 'required|between:2,15|unique:admin', //char(15) NOT NULL
        'password' => 'required|between:6,20', //varchar(64) NOT NULL
        'email' => 'email|between:6,55', //char(64) DEFAULT NULL
        'menu_group_id' => 'required|exists:power_menu_group,power_menu_group_id', //int(11) NOT NULL DEFAULT '0' COMMENT '菜单组ID'
        'status' => '', //tinyint(2) NOT NULL DEFAULT '1' COMMENT '用户状态 -1冻结，0未激活，1正常'
    ];

    public static $_MESSAGES = [//验证字段说明
        'nickname' => '真实姓名', //varchar(32) DEFAULT NULL COMMENT '真实姓名'
        'username' => '用户名', //char(15) NOT NULL
        'password' => '密码', //varchar(64) NOT NULL
        'email' => '邮箱名', //char(64) DEFAULT NULL
        'status' => '用户状态', //tinyint(2) NOT NULL DEFAULT '1' COMMENT '用户状态 -1冻结，0未激活，1正常'
    ];

    public static $_STATUS = [
        '-1' => '冻结',
        '0' => '未激活',
        '1' => '正常',
    ];

    protected $table = 'admin';

    protected $guarded = [''];

    protected function getDateFormat()
    {
        return 'U';
    }

    //获取状态名
    public function getStatusName()
    {
        return array_get(self::$_STATUS,$this->status);
    }

    //获取管理员首页地址
    public function index()
    {
        $menus = Menu::userMenus($this)->groupBy('parent_id');
        if($menus->has('0')){//有第一页
            return  array_first($menus[0],function(){
                return true;
            })->url;
        }
        //没有
        return route('logout');
    }

    //关联菜单组
    public function menuGroup()
    {
        return $this->hasOne(MenuGroup::class, 'power_menu_group_id', 'menu_group_id');
    }
    //所在角色
    public function roles()
    {
        return $this->belongsToMany(Role::class,'power_role_admin',$this->primaryKey, 'power_role_id');
    }
}
