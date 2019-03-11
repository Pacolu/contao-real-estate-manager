<?php
/**
 * Refer to LICENSE.txt distributed with the Real Estate bundle for notice of license
 */

namespace Pacolu\RealEstateBundle\Module;

use Contao\Module;
use Contao\PageModel;
use Pacolu\RealEstateBundle\Model\RealEstateModel;

/**
 * Shows a list view for a specific real estate type
 * Front end module "Real Estate Category Page"
 *
 * @author Benjamin Heuer <https://github.com/Pacolu>
 */
class EstateCategory extends Module
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_object_category';

    /**
     * Prepare Frontend for showing a list of real estates
     */
    protected function compile()
    {
        /** @var PageModel $objPage */
        global $objPage;

        $realEstates = array();
        $realEstatesDetails = array();
        $intId = $objPage->id;

        if ($intId == '16') {
            $pid = 3;
        } elseif ($intId == '17') {
            $pid = 2;
        } elseif ($intId == '19') {
            $pid = 4;
        } elseif ($intId == '20') {
            $pid = 5;
        } else {
            $pid = 2;
        }

        $realEstatesTmp = RealEstateModel::findByPid($pid);

        while ($realEstatesTmp->next()) {

            if ($intId == '16') {
                $hreflink = '{{link_url::15}}?&id=';
            } elseif ($intId == '17') {
                $hreflink = '{{link_url::18}}?&id=';
            } else {
                $hreflink = '';
            }

            $realEstates[] = array
            (
                'Kategorie'         => $realEstatesTmp->pid,
                'id'                => $realEstatesTmp->id,
                'href'              => $hreflink . $realEstatesTmp->id,
                'alt'               => $realEstatesTmp->title,
                'Titel'             => $realEstatesTmp->title,
                'Expose-Nr'         => $realEstatesTmp->expose,
                'Lage'              => $realEstatesTmp->location,
                'Bild1'             => $realEstatesTmp->display_picture,
                'Leistungen'        => $realEstatesTmp->services,
                'Zusatzinformation' => $realEstatesTmp->information,
                'tohave'            => $realEstatesTmp->published
            );

            $realEstatesDetails[] = array
            (
                'Wohnflaeche'   => $realEstatesTmp->living_space . ' m&sup2;',
                'Zimmer'        => $realEstatesTmp->rooms,
                'Warmmiete'     => $realEstatesTmp->warm_rent . ' &euro;',
                'Mieteinnahmen' => $realEstatesTmp->rental_income . ' &euro; p.a.',
                'Kaufpreis'     => $realEstatesTmp->purchase_price . ' &euro;'
            );
        }

        $this->Template->objekte = $realEstates;
        $this->Template->objektdaten = $realEstatesDetails;
    }

}

class_alias(EstateCategory::class, 'EstateCategory');
