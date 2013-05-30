<?php

namespace Morgenstille\Visual\HeatmapBundle;

/**
 * Basic rgba color representation
 *
 * Class Color
 * @package Morgenstille\Visual\HeatmapBundle
 */
class Color {

    public $r = 0;
    public $g = 0;
    public $b = 0;
    public $a = 0;

    /**
     * define the color values.
     *
     * @param $r
     * @param $g
     * @param $b
     * @param int $a
     */
    function __construct($r, $g, $b, $a = 0) {
        $this->r = $r;
        $this->g = $g;
        $this->b = $b;
        $this->a = $a;
    }
}