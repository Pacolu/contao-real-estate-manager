<?php
/**
 * Refer to LICENSE.txt distributed with the Real Estate bundle for notice of license
 */

namespace Pacolu\RealEstateBundle\Modules;

use Contao\Config;
use Contao\File;
use Contao\Image;
use Contao\Module;
use Contao\StringUtil;
use Contao\System;
use Pacolu\RealEstateBundle\Models\RealEstate;

/**
 * Shows all details for one real estate
 * Front end module "Estate Details Page"
 *
 * @author Benjamin Heuer <https://github.com/Pacolu>
 */
class EstateDetailsPage extends Module
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_objectDetails';

    /**
     * Prepare Frontend for showing all details about one real estate
     *
     * @throws \Exception
     */
    protected function compile()
    {
        $intId = ($this->Input->get('id')) ? $this->Input->get('id') : 1;
        $realEstate = RealEstate::findById($intId);
        $expose = $this->getDownloadableFile($realEstate->expose_pdf);
        $energyCertificate = $this->getDownloadableFile($realEstate->energy_certificate);

        $arrPrev[] = array
        (
            'title'          => $realEstate->title,
            'expose number'  => $realEstate->expose,
            'main image'     => $realEstate->display_picture,
            'gallery images' => $realEstate->gallery
        );

        $arrBox[] = array
        (
            'type'                 => $realEstate->type,
            'location'             => $realEstate->location,
            'plot area'            => $realEstate->plot_area . ' m&sup2;',
            'living space'         => $realEstate->living_space . ' m&sup2;',
            'usable area'          => $realEstate->usable_area . ' m&sup2;',
            'year of construction' => $realEstate->year_of_construction,
            'rooms'                => $realEstate->rooms,
            'warm rent'            => $realEstate->warm_rent . ' &euro;',
            'purchase price'       => $realEstate->purchase_price . ' &euro;',
            'commission'           => $realEstate->commission,
        );

        $arrExtra[] = array
        (
            'cold rent'           => $realEstate->cold_rent . ' &euro;',
            'warm rent'           => $realEstate->warm_rent . ' &euro;',
            'additional costs'    => $realEstate->additional_costs . ' &euro;',
            'heating cost'        => $realEstate->heating_cost . ' &euro;',
            'rental income p.a.'  => $realEstate->rental_income . ' &euro;',
            'x times rent'        => $realEstate->x_times_rent,
            'bail'                => $realEstate->bail,
            'floor'               => $realEstate->floor,
            'number of floors'    => $realEstate->number_of_floors,
            'shared flat'         => $realEstate->shared_flat,
            'heating'             => $realEstate->heating,
            'number of bedrooms'  => $realEstate->number_of_bedrooms,
            'number of bathrooms' => $realEstate->number_of_bathrooms,
            'condition'           => $realEstate->condition,
            'available'           => $realEstate->available,
            'visit'               => $realEstate->visit,
            'kitchen'             => $realEstate->kitchen,
            'balcony'             => $realEstate->balcony,
            'pets'                => $realEstate->pets,
            'pitch'               => $realEstate->pitch,
            'object_id'           => $realEstate->object_id,
            'immonet number'      => $realEstate->immonet_number,
            'information'         => $realEstate->information
        );
        $this->Template->preview = $arrPrev[0];
        $this->Template->infobox = $arrBox[0];
        $this->Template->extra = $arrExtra[0];

        if (!empty($expose)) {
            $this->Template->expose = $expose;
            if (strlen($this->Input->get('file', true))) {
                $this->sendFileToBrowser($this->Input->get('file', true));
            }
        }
        if (!empty($energyCertificate)) {
            $this->Template->energy = $energyCertificate;
            if (strlen($this->Input->get('file', true))) {
                $this->sendFileToBrowser($this->Input->get('file', true));
            }
        }
    }

    /**
     * @param string $filePath
     * @return string[]
     * @throws \Exception
     */
    private function getDownloadableFile(string $filePath)
    {
        if (empty($filePath) || !file_exists(System::getContainer()->getParameter('kernel.project_dir') . '/' . $filePath)) {
            return array();
        }
        $allowedDownload = StringUtil::trimsplit(',', strtolower(Config::get('allowedDownload')));
        $objFile = new File($filePath);
        if (!\in_array($objFile->extension, $allowedDownload) || preg_match('/^meta(_[a-z]{2})?\.txt$/', basename($filePath))) {
            return array();
        }
        $arrMeta = $this->getMetaData($objFile->meta, true);
        if ($arrMeta[0] == '') {
            $arrMeta[0] = StringUtil::specialchars($objFile->basename);
        }
        $file = array
        (
            'link'      => $arrMeta[0],
            'title'     => $arrMeta[0],
            'href'      => $this->Environment->request . ((Config::get('disableAlias') || strpos($this->Environment->request, '?') !== false) ? '&amp;' : '?') . 'file=' . System::urlEncode($filePath),
            'caption'   => $arrMeta[2],
            'filesize'  => $this->getReadableSize($objFile->filesize, 1),
            'icon'      => Image::getPath($objFile->icon),
            'mime'      => $objFile->mime,
            'meta'      => $arrMeta,
            'extension' => $objFile->extension,
            'path'      => $objFile->dirname
        );
        $file["href"] = str_replace('/files', 'files', $file["href"]);

        return $file;
    }
}
