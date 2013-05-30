Morgenstille Visual Heatmap Bundle
==================================

This Symfony2 bundle provides basic heatmap generation.

It consists of several parts
* The Service - generates the Heatmap Object
* Renderer - provide different value map to image transformations
* Spot - maps a peak on the value map.
* Heatmap - the heatmap object does all the hard work.

### Install
* The bundle is on packagist. Add ```"morgenstille/visual-heatmap-bundle": "master"``` to your composer.json.
* Add the ``new Morgenstille\Visual\HeatmapBundle\MorgenstilleVisualHeatmapBundle(),``` to your AppKernel.php.
* If you want the demos update your routing.yml

    morgenstille_visual_heatmap:
        resource: "@MorgenstilleVisualHeatmapBundle/Controller/"
        type:     annotation
        prefix:   /


### Usage
- Get your Heatmap ```$heatmap = $this->get('morgenstille.visual.heatmap')->create($width, $height);```.
- Add a spot ```$heatmap->add(new SpotInterpolate($x, $y, $radius, $intensity));```
- Render Png Response ```$heatmap->renderPngResponse(new TransparentRenderer($heatmap->getMinValue(), $heatmap->getMaxValue()));```


### Examples
Look at the demo controller [https://github.com/joemoe/visual-heatmap/blob/master/Controller/DemoController.php]