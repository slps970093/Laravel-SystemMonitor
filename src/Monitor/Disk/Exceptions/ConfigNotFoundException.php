<?php
/**
 * Created by PhpStorm.
 * User: Yu-Hsien Chou
 * Date: 2019/4/1
 * Time: 下午 09:16
 */

namespace LittleChou\SystemMonitor\Monitor\Disk\Exceptions;


use Throwable;

class ConfigNotFoundException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}