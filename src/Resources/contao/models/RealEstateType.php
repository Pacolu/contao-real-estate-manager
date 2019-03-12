<?php
/**
 * Refer to LICENSE.txt distributed with the Real Estate bundle for notice of license
 */

namespace Pacolu\RealEstateBundle\Models;

use Contao\Model;
use Contao\Model\Collection;

/**
 * Reads and writes real estate type objects
 *
 * @property integer $id
 * @property integer $tstamp
 * @property string $title
 *
 * @method static RealEstateType|null findById($id, array $opt = array())
 *
 * @method static Collection|RealEstateType[]|RealEstateType|null findAll(array $opt = array())
 *
 * Repository to load real estate type properties
 *
 * @author Benjamin Heuer <https://github.com/Pacolu>
 */
class RealEstateType extends Model
{

    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_estate_types';

}
