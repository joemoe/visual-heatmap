<?php

namespace Morgenstille\Visual\HeatmapBundle;


use Morgenstille\Visual\HeatmapBundle\Renderer\IRenderer;
use Morgenstille\Visual\HeatmapBundle\Spot\Spot;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Author Johannes Moser <sofa@morgenstille.at>
 *
 * Contains the main code for the Heatmap Bundle.
 *
 * Class Heatmap
 * @package Morgenstille\Visual\HeatmapBundle
 */
class Heatmap {

    protected $vals = array();

    protected $width;
    protected $height;

    /**
     * Constructor sets width and height and resets the heatmap.
     *
     * @param int $width
     * @param int $height
     */
    function __construct($width = 200, $height = 200) {
        $this->setHeight($height);
        $this->setWidth($width);
        $this->reset();
    }

    /**
     * inits the values tracker array.
     */
    private function reset() {
        $this->vals = array();
        for($x = 0; $x < $this->getWidth(); $x++) {
            $vals = array();
            for($y = 0; $y < $this->getHeight(); $y++) {
                $vals[] = 0;
            }
            $this->vals[] = $vals;
        }
    }

    /**
     * adds a spot to the heatmap
     *
     * @param Spot $spot
     */
    public function add(Spot $spot) {
        $spot->update($this);
    }

    /**
     * adds a value on a given x and y dot
     *
     * @param int $x
     * @param int $y
     * @param int $value
     */
    public function setValue($x, $y, $value) {
        $this->vals[$x][$y] += $value;
    }

    /**
     * loops through all the values and returns the maximum.
     *
     * @return int
     */
    public function getMaxValue() {
        $max = 0;
        for($x = 0; $x < $this->getWidth(); $x++) {
            for($y = 0; $y < $this->getHeight(); $y++) {
                $max = max($this->vals[$x][$y], $max);
            }
        }
        return $max;
    }

    /**
     * loops through the values and returns the minimum value.
     *
     * @return int
     */
    public function getMinValue() {
        if(!isset($this->vals[0]) || !isset($this->vals[0][0])) return 0;
        $min = $this->vals[0][0];
        for($x = 0; $x < $this->getWidth(); $x++) {
            for($y = 0; $y < $this->getHeight(); $y++) {
                $min = min($this->vals[$x][$y], $min);
            }
        }
        return $min;
    }

    /**
     * creates an image resource and sets the color values.
     *
     * @param IRenderer $renderer
     * @param int $scale
     * @return mixed|resource
     */
    public function render(IRenderer $renderer, $scale = 1) {
        // prepate image and fill it with an alpha color
        $im = imagecreatetruecolor($this->getWidth(), $this->getHeight());
        imagealphablending($im, true);
        imagesavealpha($im, true);
        $transparent = imagecolorallocatealpha($im, 0, 0, 0, 127);
        imagefill($im, 0, 0, $transparent);

        // create the image
        for($x = 0; $x < $this->getWidth(); $x++) {
            for($y = 0; $y < $this->getHeight(); $y++) {
                $rgb = $renderer->color($this->vals[$x][$y]);
                $color = imagecolorallocatealpha($im, $rgb->r, $rgb->g, $rgb->b, $rgb->a);
                imagefilledrectangle($im, $x, $y, $x, $y, $color);
            }
        }

        // check if image needs to be scaled
        if($scale != 1) $im = $this->scaleImage($im, $scale);

        return $im;
    }

    /**
     * resizes the new image
     *
     * @param $im
     * @param int $scale
     * @return mixed
     */
    private function scaleImage($im, $scale) {
        // calculate new width and height for the scale
        $newWidth = round($this->getWidth() * $scale);
        $newHeight = round($this->getHeight() * $scale);

        // create new image and copy content into it
        $newIm = imagecreatetruecolor($newWidth, $newHeight);
        imagealphablending($newIm, true);
        imagesavealpha($newIm, true);
        imagecopyresampled($newIm, $im, 0, 0, 0, 0, $newWidth, $newHeight, $this->getWidth(), $this->getHeight());

        // apply gaussian filter
        for ($x=1; $x<=$scale * 2; $x++) imagefilter($newIm, IMG_FILTER_GAUSSIAN_BLUR);

        return $newIm;
    }

    /**
     * renders the heatmap and creates a Symfony Response containing a JPEG.
     *
     * @param IRenderer $renderer
     * @param int $scale
     * @return Response
     */
    public function renderJpegResponse(IRenderer $renderer, $scale = 1) {
        // render the image
        $im = $this->render($renderer, $scale);

        // create a string containing the jpg data
        ob_start();
        imagejpeg($im);
        $str = ob_get_clean();

        // create the response
        $response = new Response($str, 200);
        $response->headers->set('Content-type', 'image/jpeg');

        return $response;
    }

    /**
     * renders the heatmap and creates a Symfony Response containing a PNG.
     *
     * @param IRenderer $renderer
     * @param int $scale
     * @return Response
     */
    public function renderPngResponse(IRenderer $renderer, $scale = 1) {
        $im = $this->render($renderer, $scale);

        ob_start();
        imagepng($im);
        $str = ob_get_clean();

        $response = new Response($str, 200);
        $response->headers->set('Content-type', 'image/png');

        return $response;
    }

    /**
     * @param mixed $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }

    /**
     * @return mixed
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param mixed $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * @return mixed
     */
    public function getWidth()
    {
        return $this->width;
    }
}