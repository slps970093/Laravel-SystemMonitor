<?php
/**
 * Created by PhpStorm.
 * User: Yu-Hsien Chou
 * Date: 2019/4/7
 * Time: 下午 09:15
 */

namespace LittleChou\SystemMonitor\Monitor\SmtpCheck;


class SmtpCheck{
    public $config;

    public function setConfig($config){
        $this->config = $config;
    }

    public function getConfig(){
        return $this->config;
    }

    public function getStatus(){
        foreach ( $this->config as $row ){
            $alias = (empty($row['alias'])) ? $row['host'] : $row['alias'];
            $statusList[$alias] = self::checkOnline($row['host'],is_numeric($row['port']) ? $row['port'] : 80);
        }
        return is_array($statusList) ? $statusList : [];
    }
    /**
     * 檢查對象伺服器是否可運作狀態
     * @param $host
     * @param int $port
     * @return bool
     */
    private function checkOnline($host,$port = 80){
        $socket = fsockopen($host,$port);
        $status = false;
        if ($socket) {
            $status = true;
        }
        fclose($socket);
        return $status;
    }
}