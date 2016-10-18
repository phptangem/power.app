@extends('layout')
@section('main')
<div id="content">
    <div id="content-header">
        @include('public.crumbs')
    </div>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span11">
                <div class="widget-box">
                    <div class="widget-title">
                        <span class="icon"><a href="{{URL::previous()?:'/'}}">返回</a></span>
                        <h5>{{$title}}</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form class="form-horizontal" method="post" enctype="multipart/form-data">
                            @yield('body')
                            {{csrf_field()}}
                            <input type="hidden" name="_referrer" value="{{URL::previous()}}">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function open_window(url) {
        window.open(url, '_blank', 'toolbar=no,location=yes,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=700,height=650');
    }
</script>
@stop