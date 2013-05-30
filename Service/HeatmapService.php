<?php

namespace Morgenstille\Visual\HeatmapBundle\Service;


use Morgenstille\Visual\HeatmapBundle\Heatmap;

/**
 * The heatmap services generates a heatmap. could do more some time.
 *
 * Class HeatmapService
 * @package Morgenstille\Visual\HeatmapBundle\Service
 */
class HeatmapService {

    /**
     * create a heatmap.
     *
     * @param int $width
     * @param int $height
     * @return Heatmap
     */
    public function create($width = 200, $height = 200) {
        return new Heatmap($width, $height);
    }

}