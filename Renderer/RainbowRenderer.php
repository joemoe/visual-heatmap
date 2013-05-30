<?php
namespace Morgenstille\Visual\HeatmapBundle\Renderer;

use Morgenstille\Visual\HeatmapBundle\Color;

/**
 * Renders a rainbow color
 *
 * Class RainbowRenderer
 * @package Morgenstille\Visual\HeatmapBundle\Renderer
 */
class RainbowRenderer extends Renderer {

    /**
     * returns a rainbow color vor the given value
     *
     * @param $value
     * @return Color
     */
    public function color($value) {
        if($this->max - $this->min == 0) return $this->rainbow(0);
        return $this->rainbow(($value - $this->min) / ($this->max - $this->min));
    }

    /**
     * generates the rainbow color
     *
     * @param $val
     * @return Color
     */
    private function rainbow($val) {
        // add a very low value to avoid black
        $val += 0.0000001;

        //init color offsets for green, red and blue
        $pr = pi() * 1.5;
        $pg = pi();
        $pb = pi() / 1.7;

        // init phase should be not a full a circle as it would return to blue again
        $f = pi() * 1.3;

        // calculate the color values.
        $r = sin($f * $val + $pr) * 128 + 127;
        $g = sin($f * $val + $pg) * 128 + 127;
        $b = sin($f * $val + $pb) * 128 + 127;

        return new Color($r, $g, $b);
    }
}