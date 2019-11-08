<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:79:"E:\xampp\htdocs\currency\public/../application/admin\view\student_type\add.html";i:1573181061;s:67:"E:\xampp\htdocs\currency\application\admin\view\layout\default.html";i:1570347774;s:64:"E:\xampp\htdocs\currency\application\admin\view\common\meta.html";i:1570347774;s:66:"E:\xampp\htdocs\currency\application\admin\view\common\script.html";i:1570347774;}*/ ?>
<!DOCTYPE html>
<html lang="<?php echo $config['language']; ?>">
    <head>
        <meta charset="utf-8">
<title><?php echo (isset($title) && ($title !== '')?$title:''); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="renderer" content="webkit">

<link rel="shortcut icon" href="/assets/img/favicon.ico" />
<!-- Loading Bootstrap -->
<link href="/assets/css/backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">

<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
  <script src="/assets/js/html5shiv.js"></script>
  <script src="/assets/js/respond.min.js"></script>
<![endif]-->
<script type="text/javascript">
    var require = {
        config:  <?php echo json_encode($config); ?>
    };
</script>
    </head>

    <body class="inside-header inside-aside <?php echo defined('IS_DIALOG') && IS_DIALOG ? 'is-dialog' : ''; ?>">
        <div id="main" role="main">
            <div class="tab-content tab-addtabs">
                <div id="content">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <section class="content-header hide">
                                <h1>
                                    <?php echo __('Dashboard'); ?>
                                    <small><?php echo __('Control panel'); ?></small>
                                </h1>
                            </section>
                            <?php if(!IS_DIALOG && !$config['fastadmin']['multiplenav']): ?>
                            <!-- RIBBON -->
                            <div id="ribbon">
                                <ol class="breadcrumb pull-left">
                                    <li><a href="dashboard" class="addtabsit"><i class="fa fa-dashboard"></i> <?php echo __('Dashboard'); ?></a></li>
                                </ol>
                                <ol class="breadcrumb pull-right">
                                    <?php foreach($breadcrumb as $vo): ?>
                                    <li><a href="javascript:;" data-url="<?php echo $vo['url']; ?>"><?php echo $vo['title']; ?></a></li>
                                    <?php endforeach; ?>
                                </ol>
                            </div>
                            <!-- END RIBBON -->
                            <?php endif; ?>
                            <div class="content">
                                <script src=""></script>
<form id="add-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="">

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('姓名'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-student_id" data-rule="required" data-source="student/index" class="form-control selectpage"
                   name="row[student_id]" type="text" value="">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('学币'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            加：<input checked type="radio" name="row[state]" onclick="plus()" value="0">
            减：<input type="radio" name="row[state]" onclick="reduce()" value="1">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('类型'); ?>:</label>
        <div class="col-xs-12 col-sm-8" id="cek">

        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Put_crys'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-put_crys" data-rule="required" class="form-control" name="row[put_crys]" type="number">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Operation_time'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-operation_time" data-rule="required" class="form-control datetimepicker"
                   data-date-format="YYYY-MM-DD" data-use-current="true" name="row[operation_time]" type="text"
                   value="<?php echo date('Y-m-d'); ?>">
        </div>
    </div>
    <div class="form-group layer-footer">
        <label class="control-label col-xs-12 col-sm-2"></label>
        <div class="col-xs-12 col-sm-8">
            <button type="submit" class="btn btn-success btn-embossed disabled"><?php echo __('OK'); ?></button>
            <button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>
        </div>
    </div>
</form>
<script type="text/javascript">
    let root = 'http://www.currency.com/api/type/state/';
    window.onload = function () {
        ajax({
            url: root + "0",
            type: "GET",
            data: {},
            dataType: "json",
            success: function (res) {
                var jsarr = JSON.parse(res);
                let data = jsarr.data;
                let cek = document.getElementById('cek');
                let html = '';
                for (let i = 0; i < data.length; i++) {
                    html += "<label class=\"radio-inline\">";
                    html += "<input type=\"radio\" value='" + data[i].id + "' id=\"type_id\" name=\"row[type_id]\">" + data[i].type_name + ""
                    html += "</label>";
                }
                cek.innerHTML = html;
            },
            fail: function (status) {
                // 此处放失败后执行的代码
            }
        });
    };

    function ajax(options) {
        options = options || {};
        options.type = (options.type || "GET").toUpperCase();
        options.dataType = options.dataType || "json";
        var params = formatParams(options.data);
        //创建xhr对象 - 非IE6
        if (window.XMLHttpRequest) {
            var xhr = new XMLHttpRequest();
        } else { //IE6及其以下版本浏览器
            var xhr = new ActiveXObject('Microsoft.XMLHTTP');
        }
        //GET POST 两种请求方式
        if (options.type == "GET") {
            xhr.open("GET", options.url + "?" + params, true);
            xhr.send(null);
        } else if (options.type == "POST") {
            xhr.open("POST", options.url, true);
            //设置表单提交时的内容类型
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send(params);
        }
        //接收
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                var status = xhr.status;
                if (status >= 200 && status < 300) {
                    options.success && options.success(xhr.responseText);
                } else {
                    options.fail && options.fail(status);
                }
            }
        }
    }

    //格式化参数
    function formatParams(data) {
        var arr = [];
        for (var name in data) {
            arr.push(encodeURIComponent(name) + "=" + encodeURIComponent(data[name]));
        }
        arr.push(("v=" + Math.random()).replace(".", ""));
        return arr.join("&");
    }

    function plus() { //请求加的接口
        let value = $('input:radio:checked').val();
        $.ajax({
            url: root + value,
            type: "GET",
            success: function (res) {
                let data = res.data;
                let cek = document.getElementById('cek');
                let html = '';
                for (let i = 0; i < data.length; i++) {
                    html += "<label class=\"radio-inline\">";
                    html += "<input type=\"radio\" value='" + data[i].id + "' id=\"type_id\" name=\"row[type_id]\">" + data[i].type_name + ""
                    html += "</label>";
                }
                cek.innerHTML = html;
            }
        })
    }

    function reduce() { //请求减的接口
        let value = $('input:radio:checked').val();
        $.ajax({
            url: root + value,
            type: "GET",
            success: function (res) {
                let data = res.data;
                let cek = document.getElementById('cek');
                let html = '';
                for (let i = 0; i < data.length; i++) {
                    html += "<label class=\"radio-inline\">";
                    html += "<input type=\"radio\" value='" + data[i].id + "' id=\"type_id\" name=\"row[type_id]\">" + data[i].type_name + ""
                    html += "</label>";
                }
                cek.innerHTML = html;
            }
        })
    }
</script>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo htmlentities($site['version']); ?>"></script>
    </body>
</html>