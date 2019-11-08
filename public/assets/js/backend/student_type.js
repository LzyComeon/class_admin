define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'student_type/index' + location.search,
                    add_url: 'student_type/add',
                    edit_url: 'student_type/edit',
                    del_url: 'student_type/del',
                    multi_url: 'student_type/multi',
                    table: 'student_type',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'student_id', title: __('姓名')},
                        {field: 'type_id', title: __('类型')},
                        {field: 'put_crys', title: __('Put_crys')},
                        {field: 'now_crys', title: __('Now_crys')},
                        {field: 'operation_time', title: __('Operation_time'), operate:'RANGE', addclass:'datetimerange'},
                        {field: 'state', title: __('加/减')},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});