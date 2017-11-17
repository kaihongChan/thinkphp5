/**
 * bootbox dialog封装
 */
//document ready function
jQuery(function () {
    //加载的函数
    initAjaxDialog();
    initAjax();

    //初始化ajaxDialog
    function initAjaxDialog() {
        $(document).on('click', 'button.ajaxDialog', function (e) {
            //获取控件参数
            var url = $(this).attr('data-url');
            var params = $(this).attr('data-params');
            var title = $(this).attr('data-title');
            var dialog_size = $(this).attr('dialog-size');
            var text = $(this).text();
            title = title ? title : text;
            var qp = eval('(' + params + ')');
            //加载dialog模板文件
            var jqxhr = $.ajax({
                url: url,
                data: qp,
                dataType: "html",
                type: 'GET',
            });

            jqxhr.done(function (tpl) {
                var dialog = bootbox.dialog({
                    title: title,
                    message: tpl,
                    size: dialog_size
                });

                dialog.on('click', 'button.closeBtn', function(e) {
                    bootbox.hideAll();
                });

                dialog.on('click', 'button.saveBtn', function(e) {
                    var form = dialog.find('form');
                    if ($('#'+form.attr('id')).valid()) {
                        var __url = form.attr('action');
                        $.ajax({
                            url: __url,
                            data: $('#'+form.attr('id')).serializeArray(),
                            dataType: "json",
                            type: 'POST',
                            success: function (result) {
                                if(result.code == 1){
                                    bootbox.hideAll();
                                    bootbox.alert({
                                        message:result.msg,
                                        buttons: {
                                            ok: {
                                                label: '确 定',
                                                className: 'btn-success'
                                            }
                                        },
                                        callback: function () {
                                            window.location.reload(true);
                                        }
                                    });
                                }else{
                                    bootbox.alert(result.msg);
                                }
                            }
                        });
                    }else {
                        return false;
                    }
                });
            });

            jqxhr.fail(function(jqXHR, textStatus){
                bootbox.alert(textStatus);
            });

        })
    }

    //初始化ajax加载
    function initAjax() {
        $(document).on('click', 'button.ajax', function (e) {
            //获取控件参数
            var url = $(this).attr('data-url');
            var params = $(this).attr('data-params');
            var title = $(this).attr('data-title');
            title = title ? title : $(this).text();

            var qp = eval('(' + params + ')');

            bootbox.confirm({
                message: title,
                buttons: {
                    confirm: {
                        label: '确定',
                        className: 'btn-success btn-outline'
                    },
                    cancel: {
                        label: '取消',
                        className: 'btn-danger btn-outline'
                    }
                },
                callback: function (result) {
                    if(result){
                        var jqxhr = $.ajax({
                            url: url,
                            data: qp,
                            dataType: "json",
                            type: 'POST'
                        });
                        jqxhr.done(function(r) {
                            if(r.code == 1){
                                bootbox.alert({
                                    message:r.msg,
                                    buttons: {
                                        ok: {
                                            label: '确定',
                                            className: 'btn-success btn-outline'
                                        }
                                    },
                                    callback: function () {
                                        window.location.reload(true);
                                    }
                                });
                            }else{
                                bootbox.alert({
                                    message:r.msg,
                                    buttons: {
                                        ok: {
                                            label: '确定',
                                            className: 'btn-danger btn-outline'
                                        }
                                    },
                                    callback: function () {
                                        // window.location.reload(true);
                                    }
                                });
                            }

                        });

                        jqxhr.fail(function(jqXHR, textStatus){
                            bootbox.alert(textStatus);
                        });
                    }
                }
            });
        });
    }
});