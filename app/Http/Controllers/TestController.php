<?php

namespace App\Http\Controllers;

use App\Models\Admin\Entity;
use Illuminate\Http\Request;

use App\Http\Requests;
use MongoDB\Driver\Query;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = Entity::where('id',1)->first();
        $query1 = \DB::query();
        $query2 = clone $query1;
        $query3 = clone $query1;
        $query1->from('power_role_item')
            ->whereIn('power_role_id', function($query)use($admin){//关联权限
                $query->from('power_role_admin')
                    ->where('admin_id', '=', $admin->getKey())
                    ->select('power_role_id');
            })
            ->whereIn('power_role_id', function($query){//禁用的不能提取
                $query->from('power_role')
                    ->where('status', '=', 'enable')
                    ->select('power_role_id');
            })
            ->select('power_item_id')
            ->distinct();
        $query2->from('power_role_item')
            ->orWhereIn('power_role_id', function($query)use($admin){//关联权限
                $query->from('power_role_admin')
                    ->where('admin_id', '=', $admin->getKey())
                    ->select('power_role_id');
            })
            ->orWhereIn('power_role_id', function($query){//禁用的不能提取
                $query->from('power_role')
                    ->where('status', '=', 'enable')
                    ->select('power_role_id');
            })
            ->select('power_item_id')
            ->distinct();
        $query3 = $query3->from('admin')->where(function($query){
           $query->orwhere('id',1)->orWhere('nickname',2)->WhereIn('id',[12,23]);
        });
        dd($query1->toSql(),$query2->toSql());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
