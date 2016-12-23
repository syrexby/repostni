<?php

namespace common\helpers;

class ConsoleProgressBar
{
    private $_count = 0;
    private $_step = 0;
    private $_decimalCount = 0;
    private $_displayCount = true;
    private $_realTimeDraw = false;
    private $_lastDraw = 0;

    protected $progressCount = 50;

    public function __construct($count, $decimal = false, $displayCount = true, $realTimeDraw = false)
    {
        $this->_count = $count;
        $this->_decimalCount = $decimal ? 2 : 0;
        $this->_displayCount = $displayCount;
        $this->_realTimeDraw = $realTimeDraw;

        $d = $decimal ? 10000 : 100;
        $this->_step = $this->_count / $d;
    }

    public function draw($i)
    {
        if (($i - $this->_lastDraw) < $this->_step && !$this->_realTimeDraw && $i < $this->_count) {
            return;
        }

        $this->_lastDraw = $i;

        $percent = number_format(($i / $this->_count * 100), $this->_decimalCount);
        $progressStep = $this->_count / $this->progressCount;
        $progress = round($i / $progressStep);
        echo "\r[" . str_repeat('#', $progress) . str_repeat(' ', ($this->progressCount - $progress)) . '] ' . $percent . '%';

        if ($this->_displayCount) {
            echo ' (' . number_format($i) . '/' . number_format($this->_count) . ')';
        }
    }
}