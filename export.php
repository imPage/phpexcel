<?php
require_once 'Simpleexcel.php';
header("Content-Type: application/vnd.ms-excel;charset=utf-8");
header('Content-Disposition: attachment; filename="' . time() . '.xls"');
header('Content-Type: application/octet-stream');
header("Pragma: no-cache");
header("Expires: 0");
$data = array(
    array(1, "张三", "男", 12),
    array(2, "李四", "女", 10),
    array(3, "王五", "男", 11),
);
$excel = new Simpleexcel();
//列标题
$excel->excelItem(array("序号", "姓名", "性别", "年龄"));
//每一列数据类型 1整形 非1字符串
$excel->colsAttrib(array("1", "a", "a", "1"));
//遍历写入excel
foreach ($data as $k => $v) {
    $excel->excelWrite(array($v[0], $v[1], $v[2], $v[3]));
}
//结束
$excel->excelEnd();
