<?php
/**
 * Created by PhpStorm.
 * User: Yu-Hsien Chou
 * Date: 2019/4/7
 * Time: 下午 09:31
 */

use LittleChou\SystemMonitor\Monitor\SmtpCheck\SmtpCheck;
use PHPUnit\Framework\TestCase;

class SmtpCheckTest extends TestCase
{

    public function testSetConfig()
    {
        $smtp = new SmtpCheck();
        $config = [
            [
                'alias' => 'googlesmtp',
                'host'  => 'smtp.gmail.com',
                'port'  => 993
            ]
        ];
        $smtp->setConfig($config);
        $this->assertTrue( $config === $smtp->getConfig());
    }

    public function testGetStatus()
    {
        $smtp = new SmtpCheck();
        $config = [
            [
                'alias' => 'googlesmtp',
                'host'  => 'smtp.gmail.com',
                'port'  => 993
            ]
        ];
        $smtp->setConfig($config);
        $status = $smtp->getStatus();
        $this->assertTrue($status === ['googlesmtp' => true]);
    }
}
