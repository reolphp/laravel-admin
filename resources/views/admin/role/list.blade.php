@section('title', "角色管理")
@section('content_title', '角色列表')
@section('content_title_small',  $pager->total())
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">

                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">角色列表</h3>
                        <span class="pull-right"><button type="button" onclick="location='{{ url('/admin/role/edit') }}';" class="btn btn-success pull-right">增加</button></span>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tr class="active">
                                <th>ID</th>
                                <th>角色标识</th>
                                <th>角色名称</th>
                                <th>角色描述</th>
                                <th>创建时间</th>
                                <th>修改时间</th>
                                <th>操作</th>
                            </tr>
                            <?php foreach($pager as $key=>$item) { ?>
                                <tr>
                                    <td>{{(($pager->currentPage()-1)*env('PAGE_NUM'))+$key+1}}</td>
                                    <td>{{ $item['name'] }}</td>
                                    <td>{{ $item['display_name'] }}</td>
                                    <td>{{ str_limit($item['description'], 30) }}</td>
                                    <td>{{ $item['created_at'] }}</td>
                                    <td>{{ $item['updated_at'] }}</td>
                                    <td>
                                        <a href="{{ url('/admin/role/'. $item['id'] . '/permission') }}">权限</a>
                                        <a href="{{ url('/admin/role/'.$item['id'].'/edit') }}">编辑</a>
                                        <a href="#" class="_delete_" data-url="{{ url('/admin/role/' . $item['id']) }}">删除</a>
                                    </td>
                                </tr>
                                <?php } ?>
                        </table>
                    </div>
                    <!-- /.box-body -->
                    {{$pager->links()}}
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
@endsection
@extends('admin.layouts.admin')