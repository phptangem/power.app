@extends('layout')
@section('main')
@if(isset($redirect) && $redirect)
<meta http-equiv='Refresh' content='{{$timeout}};URL={{$redirect}}'>
@endif
<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{url('home')}}" title="返回首页" class="tip-bottom"><i class="icon-home"></i> 首页</a> <a href="#" class="current">提示</a> </div>
    </div>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-content">
                        @if($status=='success')
                            <div class="alert alert-success alert-block">
                                <h4 class="alert-heading">{{$message['title']}}</h4>
                                {{$message['info']}}
                            </div>
                        @else
                            <div class="alert alert-error alert-block">
                                <h4 class="alert-heading">{{$message['title']}}</h4>
                                @if(is_array($message['info']))
                                    @foreach($message['info'] as $info)
                                        <p>{{$info}}</p>
                                    @endforeach
                                @else
                                    {{$message['info']}}
                                @endif
                            </div>
                        @endif
                        @if(isset($redirect)&&$redirect)
                            <p>系统将在 <span id="wait" style="color: blue; font-weight: bold">{{$timeout}}</span> 秒后自动跳转,如果不想等待,直接点击 <a id="href" href="{{$redirect}}" style="color: blue;">这里</a> 跳转</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@if(isset($redirect) && $redirect)
    <script type="text/javascript">
        (function(){
            var wait = document.getElementById('wait');
            var href = document.getElementById('href').href;
            var interval = setInterval(function(){
                var time = --wait.innerHTML;
                (time == 0) && (location.href = href);
            }, 1000);
        })();
    </script>
@endif
@endsection