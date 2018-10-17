@section('title', "管理员管理")
@section('content_title', '管理员管理')
@section('content_title_small',  $pager->total())
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">

                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">搜索</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <form action="{{ url('/admin/admin_users') }}" method="get">
                                <div class="form-group col-lg-2">
                                    <input name="email" value="{{ Request::get('email','') }}" type="text" class="form-control" placeholder="邮箱" />
                                </div>
                                <div class="form-group col-lg-2">
                                     <input name="username" value="{{ Request::get('username','') }}" title="username" type="text" class="form-control" placeholder="用户名">
                                </div>
                                <div class="form-group col-lg-2">
                                     <input name="mobile" value="{{ Request::get('mobile','') }}" type="text" class="form-control" placeholder="手机号码" />
                                </div>
                                <div class="form-group col-lg-2">
                                    <button type="submit" class="btn btn-default col-md-5">搜索</button>
                                    <button type="button" style="margin-left:5px;" class="btn btn-default col-md-5" onclick="location.href='{{ url("/admin/admin_users") }}';">重置</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">管理员列表</h3>
                            <span class="pull-right"><button type="button" onclick="location='{{ url("/admin/admin_user/edit") }}';" class="btn btn-success pull-right">添加</button></span>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tr class="active">
                                <th>#</th>
                                <th>用户名</th>
                                <th>邮箱</th>
                                <th>手机号码</th>
                                <th>角色</th>
                                <th>操作</th>
                            </tr>
                            @foreach ($pager as $key=>$item)
                            <tr>
                                <td>{{(($pager->currentPage()-1)*env('PAGE_NUM'))+$key+1}}</td>
                                <td>{{ $item['username'] }}</td>
                                <td>{{ $item['email'] }}</td>
                                <td>{{ $item['mobile'] }}</td>
                                <td>
                                    @foreach ($item['roles'] as $rkey => $role)
                                        {{ $role['display_name'] }} <br/>
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{ url("/admin/admin_user/".$item['id']."/edit") }}">编辑</a>
                                    <a href="#" class="_delete_" data-url="{{ url('/admin/admin_user/'.$item['id']) }}">删除</a>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    {{$pager->links()}}
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
@endsection
@extends('admin.layouts.admin')