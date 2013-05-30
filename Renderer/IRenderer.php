<?php
namespace Morgenstille\Visual\HeatmapBundle\Renderer;

use Morgenstille\Visual\HeatmapBundle\Color;

/**
 * Interface for the Renderer.
 *
 * Class IRenderer
 * @package Morgenstille\Visual\HeatmapBundle\Renderer
 */
interface IRenderer {
    /**
     * this method should set min and max values of the heatmap in the renderer.
     *
     * @param $min
     * @param $max
     */
    public function __construct($min, $max);

    /**
     * this method returns a color for a given value.
     *
     * @param $value
     * @return Color
     */
    public function color($value);
}