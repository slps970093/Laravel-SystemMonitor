<?php
/**
 * Created by PhpStorm.
 * User: Yu-Hsien Chou
 * Date: 2019/4/1
 * Time: 下午 09:19
 */

use LittleChou\SystemMonitor\Monitor\Disk\DiskFreeMonitor;
use PHPUnit\Framework\TestCase;

class DiskFreeMonitorTest extends TestCase
{
    public function test_getinfo() {
        if ( strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ) {
             $config = [
                 'C:' => [
                     'alias' => 'System Device ',
                     'min_capacity' => 5
                 ]
             ];
        } else {
            $config = [
                '/' => [
                    'alias' => 'System Device ',
                    'min_capacity' => 5
                ]
            ];
        }
        $diskFree = new DiskFreeMonitor($config);
        $data = $diskFree->getInfo();
        $this->assertArrayHasKey('SystemDevice',$data);
    }

    public function test_getMount(){
        if ( strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ) {
            $config = [
                'C:' => [
                    'alias' => 'System Device ',
                    'min_capacity' => 5
                ]
            ];
        } else {
            $config = [
                '/' => [
                    'alias' => 'System Device ',
                    'min_capacity' => 5
                ]
            ];
        }
        $diskFree = new DiskFreeMonitor($config);
        $mount = $diskFree->getMount();
        if ( strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ) {
            $this->assertTrue($mount === ['C:']);
        } else {
            $this->assertTrue($mount === ['/']);
        }
    }
}
