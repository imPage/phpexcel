<?php
/**
 * classdoc：功能说明
 *
 * @author author
 * @version $Id$
 */
class Simpleexcel
{

    public $rowsNum = 0;

    public $attrib = array();

    public $in_charset = 'UTF-8';

    /**
     * 功能说明：begin Excel stream
     * @return none
     */
    public function simpleExcel()
    {
        echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
        return;
    }

    /**
     * 功能说明：构造函数
     * @param string $inCharset [当前内容的编码方式]
     */
    public function __construct($inCharset = '')
    {
        if (!empty($inCharset)) {
            $this->in_charset = $inCharset;
        }

        $this->SimpleExcel();
    }

    /**
     * 功能说明：遍历处理数组元素
     * @param  array $string [参数数组]
     * @return none
     */
    public function excelItem($string = array())
    {
        for ($i = 0; $i < count($string); $i++) {
            $curStr = $string[$i];
            $curStr = $this->iconvToData($curStr);

            $L = strlen($curStr);
            echo pack("ssssss", 0x204, 8 + $L, $this->rowsNum, $i, 0x0, $L);
            echo $curStr;
        }
        $this->rowsNum++;
        return;
    }

    /**
     * 功能说明：attrib 属性赋值
     * @param  array $string [参数数组]
     * @return none
     */
    public function colsAttrib($string = array())
    {
        $this->attrib = $string;
        return;
    }

    /**
     * 功能说明：写excel表格
     * @param  array $string [内容数组]
     * @return none
     */
    public function excelWrite($string = array())
    {
        for ($i = 0; $i < count($string); $i++) {
            $curStr = $string[$i];
            $curStr = $this->iconvToData($curStr);

            if ($this->attrib[$i] == "1") {
                echo pack("sssss", 0x203, 14, $this->rowsNum, $i, 0x0);
                echo pack("d", $curStr);
            } else {
                $L = strlen($curStr);
                echo pack("ssssss", 0x204, 8 + $L, $this->rowsNum, $i, 0x0, $L);
                echo $curStr;
            }
        }

        $this->rowsNum++;
    }

    /**
     * 功能说明： close the stream
     * @return none
     */
    public function excelEnd()
    {
        echo pack("ss", 0x0A, 0x00);
        return;
    }

    /**
     * 功能说明：将data字符串的编码从UTF-8 转到 GB2312
     * @param  string $data [需要转换编码的字符串]
     * @return string       [编码转换后的字符串]
     */
    public function iconvToData($data)
    {
        return iconv($this->in_charset, 'gb2312', $data);
    }
}
