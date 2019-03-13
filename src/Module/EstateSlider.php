<?php
/**
 * Refer to LICENSE.txt distributed with the Real Estate bundle for notice of license
 */

namespace Pacolu\RealEstateBundle\Module;

use Contao\Module;
use Pacolu\RealEstateBundle\Model\EstatesModel;

/**
 * Shows all real estates as a slider with some key features
 * Front end module "Estate Slider"
 *
 * @author Benjamin Heuer <https://github.com/Pacolu>
 */
class EstateSlider extends Module
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_objectSlider';

    /**
     *  Prepare Frontend for real estate slider
     *
     * @throws \Exception
     */
    protected function compile()
    {
        $result = array();

        $realEstates = EstatesModel::findMultipleByPids(array(2, 3), array('limit' => 20));
        if ($realEstates !== null) {
            while ($realEstates->next()) {

                //TODO Dynamic
                // Set Link to Sell Detail Page(24) or Rent Detail Page(22)
                if ($realEstates->pid == 3) {
                    $hreflink = '{{link_url::24}}?titel=' . $realEstates->title . '&id=';
                } else {
                    $hreflink = '{{link_url::22}}?titel=' . $realEstates->title . '&id=';
                }

                // During the strange picture save behavior of Contao, I have to decode the image information before using it
                $baseImageModel = \FilesModel::findByUuid($realEstates->display_picture);
                if (!empty($baseImageModel)) {
                    $baseImage = new \File($baseImageModel->path);
                    // TODO Format Image through Configurations No PHP Calculation
                    $imageSize = $baseImage->__get('imageSize');
                    $format = $imageSize[1] / $imageSize[0];
                    if ($imageSize[0] > 275) {
                        $imageSize[0] = 275;
                        $imageSize[1] = 275 * $format;
                    }
                    if ($imageSize[1] > 190) {
                        $imageSize[1] = 190;
                        $imageSize[0] = 190 / $format;
                    }
                    $baseImage = array(
                        'path'   => $baseImage->__get('path'),
                        'width'  => $imageSize[0],
                        'height' => $imageSize[1],
                    );
                } else {
                    $baseImage = array(
                        'path'   => 'system/themes/flexible/images/placeholder.png',
                        'width'  => 190,
                        'height' => 190,
                    );
                }

                // Set all collected information together
                $result[] = array
                (
                    'category'           => $realEstates->pid,
                    'id'                 => $realEstates->id,
                    'href'               => $hreflink . $realEstates->id,
                    'alt'                => $realEstates->title,
                    'type'               => $realEstates->type,
                    'exposeNr'           => $realEstates->expose,
                    'location'           => $realEstates->location,
                    'warmRent'           => $realEstates->warm_rent . ' &euro;',
                    'purchasePrice'      => $realEstates->purchase_price . ' &euro;',
                    'rooms'              => $realEstates->rooms,
                    'rentalIncomeYearly' => $realEstates->rental_income . ' &euro;',
                    'livingSpace'        => $realEstates->living_space . ' m&sup2;',
                    'plotArea'           => $realEstates->plot_area . ' m&sup2;',
                    'mainImage'          => $baseImage,
                    'published'          => $realEstates->published
                );
            }
        }
        $this->Template->realEstates = $result;
    }

}

class_alias(EstateSlider::class, 'EstateSlider');
