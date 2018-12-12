<?php
namespace app\lib\exception;
use app\lib\exception\BaseException;
class BannerMissException extends BaseException
{
    public $code = 404;
    public $msg = '请求Banner不存在';
    public $errorcode = 40000;
}
?>