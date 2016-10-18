<?php

namespace App\Http\Controllers;

use App\Models\Power\Menu;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use View;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        View::composer(['public.menu'], function($view){
            if(Auth::check()){
                static $menus = false , $crumbs = false, $crumbs_ids = false;
                if($menus === false){
                    $lists = Menu::userMenus(Auth::user()); // 取出用户所有菜单
                    list($menus,$crumbs) = $this->arrangeAdminMenu($lists);
                    $crumb_ids = array_keys($lists->getDictionary($crumbs));
                }
                $view->with(compact('menus', 'crumb_ids', 'crumbs'));
            }
        });
    }

    //整理菜单并取出当前菜单
    private function arrangeAdminMenu($lists)
    {
        $menus = [];
        $current_action_menu = [];
        $current_controller_menu = [];
        $referer_menu = [];
        foreach($lists as $item){
            $menus[$item['parent_id']][$item['level_id']] = $item;
        }
    }

    //判断是否为当前方法
    private function isCurrentAction(Menu $menu)
    {
        static $uses =false;
        if($uses === false){
            $uses = currentRouteUses();
        }
        $url = $menu['url'];
        if(strpos('?',$menu['url']) !==false){
            $url = strstr($url, '?', true);
        }

        return Request::is(trim($url,'/')) && (empty($menu['item']) || $menu['item']['code'] === $uses);
    }
}
