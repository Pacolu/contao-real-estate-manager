<?php
/**
 * Refer to LICENSE.txt distributed with the Real Estate bundle for notice of license
 */

// Back end modules
array_insert($GLOBALS['BE_MOD']['content'], 1, array
(
    'Real Estate Manager' => array
    (
        'tables' => array('tl_estate_types', 'tl_estates',),
        'icon'   => 'system/modules/real-estate-manager/html/icon.gif',
    )
));

// Front end modules
array_insert($GLOBALS['FE_MOD'], 2, array
(
    'miscellaneous' => array(
        'Estate Slider' => 'Pacolu\\RealEstateBundle\\Modules\\EstateSlider',
        'Estate Details Page' => 'Pacolu\\RealEstateBundle\\Modules\\EstateDetailsPage',
        'Estate Category' => 'Pacolu\\RealEstateBundle\\Modules\\EstateCategory',
	)
));

// Add permissions
$GLOBALS['TL_PERMISSIONS'][] = 'real-estate-manager';
