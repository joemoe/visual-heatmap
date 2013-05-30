<?php
namespace Morgenstille\Visual\HeatmapBundle\Renderer;

use Morgenstille\Visual\HeatmapBundle\Color;

/**
 * A Renderer that generates a black and white heatmap.
 *
 * Class Renderer
 * @package Morgenstille\Visual\HeatmapBundle\Renderer
 */
class Renderer implements IRenderer {

    protected $min;
    protected $max;

    /**
     * sets min and max values of the heatmap
     *
     * @param $min
     * @param $max
     */
    public function __construct($min, $max) {
        $this->min = $min;
        $this->max = $max;
    }

    /**
     * calculates the color vom white to black
     *
     * @param $value
     * @return Color
     */
    public function color($value) {
        if($this->max - $this->min == 0) return new Color(254,254,254);
        $color = round(254 - ($value - $this->min) / ($this->max - $this->min) * 254);
        return new Color($color, $color, $color);
    }
}