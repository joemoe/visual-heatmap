<?php

namespace Morgenstille\Visual\HeatmapBundle\Spot;

use Morgenstille\Visual\HeatmapBundle\Heatmap;

/**
 * The Spot class shows a single dot on the heatmaps. not to nice.
 *
 * Class Spot
 * @package Morgenstille\Visual\HeatmapBundle\Spot
 */
class Spot {

    protected $x;
    protected $y;
    protected $value;

    /**
     * set x, y, and value.
     *
     * @param int $x
     * @param int $y
     * @param int $value
     */
    function __construct(int $x, int $y, int $value) {
        $this->x = $x;
        $this->y = $y;
        $this->value = $value;
    }

    /**
     * sets the value on the heatmap for the single dot.
     *
     * @param Heatmap $heatmap
     */
    public function update(Heatmap $heatmap) {
        $heatmap->setValue($this->x, $this->y, $this->value);
    }
}