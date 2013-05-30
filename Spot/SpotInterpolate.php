<?php

namespace Morgenstille\Visual\HeatmapBundle\Spot;


use Morgenstille\Visual\HeatmapBundle\Heatmap;

/**
 * Does a little more then the basic spot. also interpolates the value to a given radius in a linear way.
 *
 * Class SpotInterpolate
 * @package Morgenstille\Visual\HeatmapBundle\Spot
 */
class SpotInterpolate extends Spot {

    protected $x;
    protected $y;
    protected $radius;
    protected $value;

    /**
     * @param int|int $x
     * @param int|int $y
     * @param int|int $radius
     * @param $value
     */
    function __construct($x, $y, $radius, $value) {
        $this->x = $x;
        $this->y = $y;
        $this->radius = $radius;
        $this->value = $value;
    }

    /**
     * calculates the circle values linear.
     *
     * @param Heatmap $heatmap
     */
    public function update(Heatmap $heatmap) {
        for($x = max(0, $this->x - $this->radius); $x < min($heatmap->getWidth(), $this->x + $this->radius); $x++) {
            for($y = max(0, $this->y - $this->radius); $y < min($heatmap->getHeight(), $this->y + $this->radius); $y++) {
                $radius = sqrt(pow($x - $this->x, 2) + pow($y - $this->y, 2));
                if($radius > $this->radius) continue;
                $heatmap->setValue($x, $y, ($this->radius - $radius) * $this->value);
            }
        }
    }
}