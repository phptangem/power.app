<?php
//面包屑
?>
<div id="breadcrumb">
    @section('crumbs')
    @if(isset($crumbs) && count($crumbs))
    <a href="{{$crumbs[0]['url']}}" class="tip-bottom"><i class="icon-home"></i>{{$crumbs[0]['name']}}</a>
    @foreach(array_slice($crumbs,1) as $key=>$menu)
    <a href="{{$menu['url']}}"<?php if ($key == count($crumbs)-2) { ?> class="current"<?php } ?>>{{$menu['name']}}</a>
    @endforeach
    @endif
    @show
</div>
