<?php
/**
 * Refer to LICENSE.txt distributed with the Real Estate bundle for notice of license
 */

namespace Pacolu\RealEstateBundle\Module;

use Contao\Module;
use Pacolu\RealEstateBundle\Model\RealEstateModel;

/**
 * Shows all real estates as a slider with some key features
 * Front end module "Real Estate Management"
 *
 * @author Benjamin Heuer <https://github.com/Pacolu>
 */
class EstateManagement extends Module
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_object_management';

    /**
     *  Prepare Frontend for real estate slider
     */
    protected function compile()
    {
        $result = array();

        $realEstates = RealEstateModel::findMultipleByPids(array(2, 3), array('limit' => 20));
        if ($realEstates !== null) {
            while ($realEstates->next()) {
                if ($realEstates->pid == 3) {
                    $hreflink = '{{link_url::15}}?titel=' . $realEstates->title . '&id=';
                } else {
                    $hreflink = '{{link_url::18}}?titel=' . $realEstates->title . '&id=';
                }
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
                    'imageMain'          => $realEstates->display_picture,
                    'available'          => $realEstates->published
                );
            }
        }
        $this->Template->realEstates = $result;
    }

}

class_alias(EstateManagement::class, 'EstateManagement');
