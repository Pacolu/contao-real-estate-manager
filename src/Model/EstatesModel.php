<?php
/**
 * Refer to LICENSE.txt distributed with the Real Estate bundle for notice of license
 */

namespace Pacolu\RealEstateBundle\Model;

use \Model\Collection;

/**
 * Reads and writes real estate objects
 *
 * @property integer $id
 * @property integer $pid
 * @property integer $tstamp
 * @property string $title
 * @property string $location
 * @property string $cold_rent
 * @property string $living_space
 * @property string $warm_rent
 * @property string $gallery
 * @property string $expose
 * @property string $information
 * @property string $published
 * @property integer $date
 * @property string $type
 * @property string $additional_costs
 * @property string $heating_cost
 * @property string $purchase_price
 * @property string $bail
 * @property string $rooms
 * @property string $number_of_bedrooms
 * @property string $number_of_bathrooms
 * @property string $usable_area
 * @property string $condition
 * @property string $year_of_construction
 * @property string $available
 * @property string $visit
 * @property string $heating
 * @property string $floor
 * @property string $number_of_floors
 * @property string $kitchen
 * @property string $pets
 * @property string $shared_flat
 * @property string $bath
 * @property string $pitch
 * @property string $object_id
 * @property string $immonet_number
 * @property string $display_picture
 * @property string $services
 * @property string $balcony
 * @property string $rental_income
 * @property string $x_times_rent
 * @property string $commission
 * @property string $plot_area
 * @property string $expose_pdf
 * @property string $energy_certificate
 *
 * @method static EstatesModel|null findById($id, array $opt = array())
 *
 * @method static Collection|EstatesModel[]|EstatesModel|null findMultipleByIds($val, array $arrOptions = array())
 * @method static Collection|EstatesModel[]|EstatesModel|null findAll(array $arrOptions = array())
 *
 * Repository to load real estate properties
 *
 * @author Benjamin Heuer <https://github.com/Pacolu>
 */
class EstatesModel extends \Model
{

    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_estates';

    /**
     * Find sent newsletters by their parent ID
     *
     * @param int[] $arrPids The real estate type ids
     * @param array $arrOptions An optional options array
     *
     * @return Collection|EstatesModel[]|EstatesModel|null A collection of models or null if there are no fitting objects
     */
    public static function findMultipleByPids(array $arrPids, array $arrOptions = array())
    {
        $t = static::$strTable;
        $arrColumns = array("$t.pid IN(" . implode(',', array_map('\intval', $arrPids)) . ")");

        if (!isset($arrOptions['order'])) {
            $arrOptions['order'] = "$t.published DESC, $t.date DESC";
        }

        return static::findBy($arrColumns, null, $arrOptions);
    }

    /**
     * Find sent newsletters by their parent ID
     *
     * @param int[] $val The real estate type id
     * @param array $arrOptions An optional options array
     *
     * @return Collection|EstatesModel[]|EstatesModel|null A collection of models or null if there are no fitting objects
     */
    public static function findByPid($val, array $arrOptions = array())
    {
        $t = static::$strTable;
        $arrColumns = array("$t.pid = ?");

        if (!isset($arrOptions['order'])) {
            $arrOptions['order'] = "$t.published DESC, $t.date DESC";
        }

        return static::findBy($arrColumns, $val, $arrOptions);
    }
}
class_alias(EstatesModel::class, 'EstatesModel');
