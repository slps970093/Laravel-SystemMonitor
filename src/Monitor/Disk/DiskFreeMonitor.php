<?php
/**
 * Created by PhpStorm.
 * User: Yu-Hsien Chou
 * Date: 2019/4/1
 * Time: 下午 08:47
 */

namespace LittleChou\SystemMonitor\Monitor\Disk;


use LittleChou\SystemMonitor\Monitor\Disk\Exceptions\ConfigNotFoundException;

class DiskFreeMonitor
{
    private $config;

    const DiskStatus_Warning = 'warning';
    const DiskStatus_Normal = 'norming';

    const DiskFree_MinCapacity = 'min_capacity';
    const DiskFree_MountAlias = 'alias';


    public function __construct( $config )
    {
        $this->config = $config;
    }

    public function getInfo() {
         if( !is_array($this->config) ){
            throw new ConfigNotFoundException('can not find disk config');
         }
         foreach ($this->config as $mount => $info ) {
             $alias = ( !empty($info[ self::DiskFree_MountAlias ]) ) ? str_replace(" ","", trim($info[ self::DiskFree_MountAlias ])) : trim($mount);
             $diskInfo[$alias] = self::getDiskInfo($mount,$info);
         }
         return is_array($diskInfo) ? $diskInfo : [];
    }

    public function getMount() {
        if( !is_array($this->config) ){
            throw new ConfigNotFoundException('can not find disk config');
        }
        foreach ($this->config as $mount => $info ) {
            $diskMount[] = $mount;
        }
        return is_array($diskMount) ? $diskMount : [];
    }

    private function getDiskInfo ( $mount , $info ) {
        $minCapacity = ( is_numeric($info[ self::DiskFree_MinCapacity ])) ? $info[ self::DiskFree_MinCapacity ] : false;
        if ( $minCapacity === false ) {
            $diskInfo = [
                'free' => number_format(self::conventByteToGb( disk_free_space($mount)),2),
                'total' => number_format(self::conventByteToGb(disk_total_space($mount)),2),
                'mount' => $mount
            ];
        } else {
            $status = ( self::conventByteToGb(disk_free_space($mount)) < $info[ self::DiskFree_MinCapacity ]) ? self::DiskStatus_Warning : self::DiskStatus_Normal;
            $diskInfo = [
                'status' => $status,
                'free' => number_format(self::conventByteToGb(disk_free_space($mount)),2),
                'total' => number_format(self::conventByteToGb(disk_total_space($mount)),2),
                'mount' => $mount
            ];
        }
        return $diskInfo;
    }



    private function conventByteToGb( $byte ){
        return $byte / 1024 / 1024 / 1024;
    }
}