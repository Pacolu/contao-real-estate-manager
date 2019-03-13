<?php
/**
 * Refer to LICENSE.txt distributed with the Real Estate bundle for notice of license
 */

namespace Pacolu\RealEstateBundle\Module;

use Contao\Module;
use Contao\PageModel;
use Pacolu\RealEstateBundle\Model\EstatesModel;

/**
 * Shows a list view for a specific real estate type
 * Front end module "Estate Category"
 *
 * @author Benjamin Heuer <https://github.com/Pacolu>
 */
class EstateCategory extends Module
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_objectCategory';

    /**
     * Prepare Frontend for showing a list of real estates
     *
     * @throws \Exception
     */
    protected function compile()
    {
        /** @var PageModel $objPage */
        global $objPage;

        $realEstates = array();
        $realEstatesDetails = array();
        $intId = $objPage->id;

        //TODO DYNAMIC
        // Mapping on which page I need which type of real estate objects
        if ($intId == '23') { // 23 is Page Verkauf
            $pid = 3; // Type Verkauf
        } elseif ($intId == '21') { // 21 is Page Vermietung
            $pid = 2; // Type Vermietung
        } elseif ($intId == '17') { // 17 is Page Verwaltung
            $pid = 4; // Type Verwaltung
        } elseif ($intId == '18') { // 18 is Page Objektbetreuung
            $pid = 5; // Type Objektbetreuung
        } else {
            $pid = 2;
        }

        $realEstatesTmp = EstatesModel::findByPid($pid);

        while ($realEstatesTmp->next()) {

            //TODO Dynamic
            // Set Link to Sell Detail Page(24) or Rent Detail Page(22)
            if ($intId == '23') {
                $hreflink = '{{link_url::24}}?&id=';
            } elseif ($intId == '21') {
                $hreflink = '{{link_url::22}}?&id=';
            } else {
                $hreflink = '';
            }

            // During the strange picture save behavior of Contao, I have to decode the image information before using it
            $baseImageModel = \FilesModel::findByUuid($realEstatesTmp->display_picture);
            if (!empty($baseImageModel)) {
                $baseImage = new \File($baseImageModel->path);
                // TODO Format Image through Configurations No PHP Calculation
                $imageSize = $baseImage->__get('imageSize');
                $format = $imageSize[1] / $imageSize[0];
                if ($imageSize[0] > 235) {
                    $imageSize[0] = 235;
                    $imageSize[1] = 235 * $format;
                }
                if ($imageSize[1] > 180) {
                    $imageSize[1] = 180;
                    $imageSize[0] = 180 / $format;
                }
                $baseImage = array(
                    'path'   => $baseImage->__get('path'),
                    'width'  => $imageSize[0],
                    'height' => $imageSize[1],
                );
            } else {
                $baseImage = array(
                    'path'   => 'system/themes/flexible/images/placeholder.png',
                    'width'  => 180,
                    'height' => 180,
                );
            }

            // Set all collected information together
            $realEstates[] = array
            (
                'category'    => $realEstatesTmp->pid,
                'id'          => $realEstatesTmp->id,
                'href'        => $hreflink . $realEstatesTmp->id,
                'alt'         => $realEstatesTmp->title,
                'title'       => $realEstatesTmp->title,
                'exposeNr'    => $realEstatesTmp->expose,
                'location'    => $realEstatesTmp->location,
                'mainImage'   => $baseImage,
                'services'    => $realEstatesTmp->services,
                'information' => $realEstatesTmp->information,
                'published'   => $realEstatesTmp->published
            );

            $realEstatesDetails[] = array
            (
                'livingSpace'        => $realEstatesTmp->living_space . ' m&sup2;',
                'rooms'              => $realEstatesTmp->rooms,
                'warmRent'           => $realEstatesTmp->warm_rent . ' &euro;',
                'rentalIncomeYearly' => $realEstatesTmp->rental_income . ' &euro; p.a.',
                'purchasePrice'      => $realEstatesTmp->purchase_price . ' &euro;'
            );
        }

        $this->Template->realEstates = $realEstates;
        $this->Template->realEstateData = $realEstatesDetails;
    }

}

class_alias(EstateCategory::class, 'EstateCategory');
