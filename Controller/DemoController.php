<?php

namespace Morgenstille\Visual\HeatmapBundle\Controller;

use Morgenstille\Visual\HeatmapBundle\Renderer\RainbowRenderer;
use Morgenstille\Visual\HeatmapBundle\Renderer\Renderer;
use Morgenstille\Visual\HeatmapBundle\Renderer\TransparentRenderer;
use Morgenstille\Visual\HeatmapBundle\Spot\SpotInterpolate;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

/**
 * contains some testcases. to use it update your routing.yml
 *
 * Class DefaultController
 * @package Morgenstille\Visual\HeatmapBundle\Controller
 */
class DemoController extends Controller
{
    /**
     * Test action. Lists the Images generated by the actions below.
     *
     * @Route("/demo")
     * @Template()
     */
    public function demoAction()
    {
        return array();
    }

    /**
     * Example Code that generates a Transparent Heatmap with interpolated spots.
     *
     * @Route("/transparent", name="heatmap_transparent")
     */
    public function transparentAction() {
        $width = 400;
        $height = 300;
        $radius = 200;
        $numberOfSpots = 20;
        $intensity = 20;

        // get service
        $heatmap = $this->get('morgenstille.visual.heatmap')->create($width, $height);

        // add random spots to the heatmap
        for($i = 0; $i < $numberOfSpots; $i++) {
            $heatmap->add(new SpotInterpolate(rand(0, $width), rand(0, $height), rand(0, $radius), rand(0, $intensity)));
        }

        // render the heatmap and return the png response
        return $heatmap->renderPngResponse(new TransparentRenderer($heatmap->getMinValue(), $heatmap->getMaxValue()));

    }

    /**
     * Example Code that generates a Blackwhite Image and returns a Jpeg.
     *
     * @Route("/blackwhite", name="heatmap_blackwhite")
     */
    public function blackwhiteAction() {
        $width = 400;
        $height = 300;
        $radius = 200;
        $numberOfSpots = 20;
        $intensity = 20;

        // get service
        $heatmap = $this->get('morgenstille.visual.heatmap')->create($width, $height);

        // add random spots to the heatmap
        for($i = 0; $i < $numberOfSpots; $i++) {
            $heatmap->add(new SpotInterpolate(rand(0, $width), rand(0, $height), rand(0, $radius), rand(0, $intensity)));
        }

        // render the heatmap and return the png response
        return $heatmap->renderJpegResponse(new Renderer($heatmap->getMinValue(), $heatmap->getMaxValue()));

    }

    /**
     * Example Code that generates a Rainbow Heatmap.
     *
     * @Route("/rainbow", name="heatmap_rainbow")
     */
    public function rainbowAction() {
        $width = 400;
        $height = 300;
        $radius = 200;
        $numberOfSpots = 20;
        $intensity = 20;

        // get service
        $heatmap = $this->get('morgenstille.visual.heatmap')->create($width, $height);

        // add random spots to the heatmap
        for($i = 0; $i < $numberOfSpots; $i++) {
            $heatmap->add(new SpotInterpolate(rand(0, $width), rand(0, $height), rand(0, $radius), rand(0, $intensity)));
        }

        // render the heatmap and return the jpeg response
        return $heatmap->renderPngResponse(new RainbowRenderer($heatmap->getMinValue(), $heatmap->getMaxValue()));

    }

    /**
     * Example code the generates a rainbow heatmap and scales it by 4.
     *
     * @Route("/resampled", name="heatmap_resampled")
     */
    public function resampledAction() {
        $width = 400 / 4;
        $height = 300 / 4;
        $radius = 10;
        $numberOfSpots = 20;
        $intensity = 20;

        // get service
        $heatmap = $this->get('morgenstille.visual.heatmap')->create($width, $height);

        // add random spots to the heatmap
        for($i = 0; $i < $numberOfSpots; $i++) {
            $heatmap->add(new SpotInterpolate(rand(0, $width), rand(0, $height), rand(0, $radius), rand(0, $intensity)));
        }

        // render the heatmap and return the png response
        return $heatmap->renderPngResponse(new RainbowRenderer($heatmap->getMinValue(), $heatmap->getMaxValue()), 4);

    }
}
