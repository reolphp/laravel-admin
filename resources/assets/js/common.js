require('sweetalert');

$(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("input, textarea").click(function(e) {
        $(e.currentTarget).parents('.form-group').removeClass('has-error');
        $(e.currentTarget).parents('.form-group').find('.help-block').remove();
    });

    $('._submit_').click(function (e) {
        var _this = $(this);
        var _form_id = _this.attr('data-form-id');
        var _url = _this.attr('data-url');
        var _refresh_url = _this.attr('data-refresh-url');
        var _method = 'POST';
        var _id = $("input[name=id]").val();
        $(".help-block").parent().remove();
        $(".has-error").removeClass('has-error');
        e.preventDefault();
        if (_url === null || _url ===undefined || _url === '') _url = $('#' + _form_id).attr("action");
        if (_id > 0) {
            _method = 'PUT';
            _url = _url + '/' + _id;
        }
        var params = $('#' + _form_id).serialize() + "&_method=" + _method;

        //请求
        $.post(_url, params, function(data){
            swal("操作成功！",'','success');
            if (_refresh_url !== null && _refresh_url !== undefined && _refresh_url !== '') {
                window.location.href=_refresh_url;
                return;
            }
            location.reload();
        }).fail(function(data) {
            var params = data.responseJSON;
            if (params.errors !== undefined) params = params.errors;
            var status = data.status;
            //表格验证错误
            if (status == 422) {
                var msg = params;
                for(e in msg) {
                    $("[name="+e+"]").parents('.form-group').removeClass('has-error').addClass('has-error');
                    $parent = $("[name="+e+"]").parents('div').first();
                    if ($parent.hasClass("input-group")) {
                        $parent.after("<div><span class='help-block m-b-none'>"+msg[e]+"</span></div>");
                    } else {
                        $parent.append("<div><span class='help-block m-b-none'>"+msg[e]+"</span></div>");
                    }
                }
                return;
            //权限
            } else if (status == 403){
                swal(params,'','warning');
                return;
            } else {
                swal(params,'','error');
                return;
            }
        });
    });

    $('._delete_').click(function () {
        swal({
            title: '确定删除吗？', 
            text: '你将无法恢复它！', 
            icon: 'warning',
            buttons: {
                cancel: "取消",
                confirm: "确定",
            }
        }).then(isConfirm =>{
                if(isConfirm){   
                        var _this = $(this);
                        var _url = _this.attr('data-url');
                        $.post(_url, {_method: 'DELETE'}, function (response) {
                            if (response.role) {
                                swal(response.role,'','warning');
                                return;
                            }
                            if (response.status == 200) {
                                swal(response.msg,'','success');
                                location.reload();
                                return;
                            } else {
                                swal(response.msg,'error');
                                return;
                            }
                        }).fail(function(data) {
                            var params = data.responseJSON;
                            var status = data.status;
                            swal(params,'','error');
                        });
                    }  
                }
            )
    });


});