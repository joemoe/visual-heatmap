<?php

namespace Morgenstille\Visual\HeatmapBundle\Renderer;


use Morgenstille\Visual\HeatmapBundle\Color;

/**
 * renders a alpha transparent heatmap on a black base.
 *
 * TODO: make base color in a parameter
 *
 * Class TransparentRenderer
 * @package Morgenstille\Visual\HeatmapBundle\Renderer
 */
class TransparentRenderer extends Renderer {

    /**
     * returns the transparency value.
     *
     * @param $value
     * @return Color
     */
    public function color($value) {
        if($this->max - $this->min == 0) return new Color(0, 0, 0, 0);
        $transparency = round(($value - $this->min) / ($this->max - $this->min) * 127);
        return new Color(0, 0, 0, $transparency);
    }
}