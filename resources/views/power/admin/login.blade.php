@extends('layout')
@section('css')
    <link rel="stylesheet" href="css/matrix-login.css" />
@endsection
@section('main')
    <div id="loginbox">
        {!! Form::open(['url'=> 'login']) !!}
        <div class="control-group normal_text"> <h3><img src="img/logo.png" alt="Logo" /></h3></div>
        <div class="control-group">
            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_lg"><i class="icon-user"></i></span>
                    {!! Form::text('username',null, ['placeholder'=>'用户名', 'required' => 'true' ,'minlength'=>3, 'maxlength'=> '30']) !!}
                </div>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_ly"><i class="icon-lock"></i></span>
                    {!! Form::password('password', ['placeholder'=>'密码', 'required'=>'true', 'minlength'=> '3', 'maxlength'=> '30']) !!}
                </div>
            </div>
        </div>
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="form-actions">
            <span class="pull-right">{!! Form::submit('登陆', ['class'=>'btn btn-success ajax-submit-data']) !!}</span>
        </div>
        {!! Form::close() !!}
    </div>
@endsection