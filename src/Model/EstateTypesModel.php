<?php
/**
 * Refer to LICENSE.txt distributed with the Real Estate bundle for notice of license
 */

namespace Pacolu\RealEstateBundle\Model;

use \Model\Collection;

/**
 * Reads and writes real estate type objects
 *
 * @property integer $id
 * @property integer $tstamp
 * @property string $title
 *
 * @method static EstateTypesModel|null findById($id, array $opt = array())
 *
 * @method static Collection|EstateTypesModel[]|EstateTypesModel|null findAll(array $opt = array())
 *
 * Repository to load real estate type properties
 *
 * @author Benjamin Heuer <https://github.com/Pacolu>
 */
class EstateTypesModel extends \Model
{

    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_estate_types';

}
class_alias(EstateTypesModel::class, 'EstateTypesModel');
