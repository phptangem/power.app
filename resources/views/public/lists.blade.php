@extends('layout')
@section('main')
<link rel="stylesheet" href="/css/uniform.css" />
<!--<link rel="stylesheet" href="/css/select2.css" />
<script src="{{URL::asset('js/My97DatePicker/')}}/WdatePicker.js"></script>-->
<style type="text/css">
    .order-by{position: relative;cursor: pointer;}
    .order-by:before,.order-by:after{display:inline-block;position: absolute;right: 0px;width: 20px;height: 20px;color: #9A9A9A;}
    .order-by:before{content: '∧';top:0px;}
    .order-by:after{content: '∨';bottom: 0px;}
    .order-desc:after{color: #009900;}
    .order-asc:before{color: #009900;}
    ul.pagination .active{border-color: red;color: red;cursor: default;}
    ul.pagination .disabled{border-color: #ccc;color: #ccc;cursor: default;}
</style>
<div id="content">
    <div id="content-header">
        @include('public.crumbs')
    </div>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                @if(isControllerPower('add') && !isset($not_add))<a href="add.html"><button class="btn">新增</button></a>@endif
                @if(isControllerPower('addVip') && !isset($not_add))<a href="add.html"><button class="btn">新增</button></a>@endif
                @section('search')@show
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span><h5>{{$description}}管理</h5>
                    </div>
                    <div class="widget-content nopadding">
                        @yield('lists')
                    </div>
                </div>
                <?php $lists->setPath(Request::url());?>
                {!!$lists->render()!!}
            </div>
        </div>
    </div>
</div>
@stop