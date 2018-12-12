<?php
namespace app\api\exception;

use app\lib\exception\BaseException;


class ThemeException extends BaseException
{
    public $code = 404;
    public $msg = '指定的主题不存在，请检查id';
    public $errorcode = 30000;
}
?>