<?php
/**
 * Refer to LICENSE.txt distributed with the Real Estate bundle for notice of license
 */

namespace Pacolu\RealEstateBundle\Module;

use Contao\Config;
use Contao\File;
use Contao\Image;
use Contao\Module;
use Contao\StringUtil;
use Contao\System;
use Pacolu\RealEstateBundle\Model\EstatesModel;

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
        $realEstate = EstatesModel::findById($intId);
        $expose = $this->getDownloadableFile($realEstate->expose_pdf);
        $energyCertificate = $this->getDownloadableFile($realEstate->energy_certificate);

        // During the strange picture save behavior of Contao, I have to decode the image information before using it
        $baseImageModel = \FilesModel::findByUuid($realEstate->display_picture);
        if (!empty($baseImageModel)) {
            $baseImage = new \File($baseImageModel->path);
            // TODO Format Image through Configurations No PHP Calculation
            $imageSize = $baseImage->__get('imageSize');
            $format = $imageSize[1] / $imageSize[0];
            if ($imageSize[0] > 440) {
                $imageSize[0] = 440;
                $imageSize[1] = 440 * $format;
            }
            if ($imageSize[1] > 305) {
                $imageSize[1] = 305;
                $imageSize[0] = 305 / $format;
            }
            $baseImage = array(
                'path'   => $baseImage->__get('path'),
                'width'  => $imageSize[0],
                'height' => $imageSize[1],
            );
        } else {
            $baseImage = array(
                'path'   => 'system/themes/flexible/images/placeholder.png',
                'width'  => 305,
                'height' => 305,
            );
        }

        $galleryImageModels = StringUtil::deserialize($realEstate->gallery, true);
        $galleryImageModels = \FilesModel::findMultipleByUuids($galleryImageModels);
        $gallery = array();
        foreach ($galleryImageModels as $galleryImageModel) {
            $gallery[] = $galleryImageModel->path;
        }

        // Collecting all objects for the template
        $arrPrev[] = array
        (
            'title'         => $realEstate->title,
            'exposeNr'      => $realEstate->expose,
            'mainImage'     => $baseImage,
            'galleryImages' => $gallery
        );

        $arrBox[] = array
        (
            'type'               => $realEstate->type,
            'location'           => $realEstate->location,
            'plotArea'           => $realEstate->plot_area . ' m&sup2;',
            'livingSpace'        => $realEstate->living_space . ' m&sup2;',
            'usableArea'         => $realEstate->usable_area . ' m&sup2;',
            'yearOfConstruction' => $realEstate->year_of_construction,
            'rooms'              => $realEstate->rooms,
            'warmRent'           => $realEstate->warm_rent . ' &euro;',
            'purchasePrice'      => $realEstate->purchase_price . ' &euro;',
            'commission'         => $realEstate->commission,
        );

        $arrExtra[] = array
        (
            'coldRent'           => $realEstate->cold_rent . ' &euro;',
            'warmRent'           => $realEstate->warm_rent . ' &euro;',
            'additionalCosts'    => $realEstate->additional_costs . ' &euro;',
            'heatingCost'        => $realEstate->heating_cost . ' &euro;',
            'rentalIncomeYearly' => $realEstate->rental_income . ' &euro;',
            'xTimesRent'         => $realEstate->x_times_rent,
            'bail'               => $realEstate->bail,
            'floor'              => $realEstate->floor,
            'numberOfFloors'     => $realEstate->number_of_floors,
            'sharedFlat'         => $realEstate->shared_flat,
            'heating'            => $realEstate->heating,
            'numberOfBedrooms'   => $realEstate->number_of_bedrooms,
            'numberOfBathrooms'  => $realEstate->number_of_bathrooms,
            'condition'          => $realEstate->condition,
            'available'          => $realEstate->available,
            'visit'              => $realEstate->visit,
            'kitchen'            => $realEstate->kitchen,
            'balcony'            => $realEstate->balcony,
            'pets'               => $realEstate->pets,
            'pitch'              => $realEstate->pitch,
            'objectId'           => $realEstate->object_id,
            'immonetNumber'      => $realEstate->immonet_number,
            'information'        => $realEstate->information
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
     * @param string $fileSRC
     * @return string[]
     * @throws \Exception
     */
    private function getDownloadableFile(string $fileSRC)
    {
        $fileModel = \FilesModel::findByUuid($fileSRC);
        if (empty($fileModel) || !file_exists(System::getContainer()->getParameter('kernel.project_dir') . '/' . $fileModel->path)) {
            return array();
        }
        $allowedDownload = StringUtil::trimsplit(',', strtolower(Config::get('allowedDownload')));
        $objFile = new File($fileModel->path);
        if (!\in_array($objFile->__get('extension'), $allowedDownload) || preg_match('/^meta(_[a-z]{2})?\.txt$/', $objFile->__get('basename'))) {
            return array();
        }
        $arrMeta = $this->getMetaData($fileModel->meta, true);
        if ($arrMeta[0] == '') {
            $arrMeta[0] = StringUtil::specialchars($objFile->__get('basename'));
        }
        $file = array
        (
            'link'      => $arrMeta[0],
            'title'     => $arrMeta[0],
            'href'      => $this->Environment->request . ((Config::get('disableAlias') || strpos($this->Environment->request, '?') !== false) ? '&amp;' : '?') . 'file=' . System::urlEncode($fileModel->path),
            'caption'   => $arrMeta[2],
            'filesize'  => $this->getReadableSize($objFile->__get('filesize'), 1),
            'icon'      => Image::getPath($objFile->__get('icon')),
            'mime'      => $objFile->__get('mime'),
            'meta'      => $arrMeta,
            'extension' => $objFile->__get('extension'),
            'path'      => $objFile->__get('dirname')
        );
        $file["href"] = str_replace('/files', 'files', $file["href"]);

        return $file;
    }
}

class_alias(EstateDetailsPage::class, 'EstateDetailsPage');
