<?php
/**
 * Refer to LICENSE.txt distributed with the Real Estate bundle for notice of license
 */

// Back end modules
array_insert($GLOBALS['BE_MOD']['content'], 1, array
(
    'real-estate-manager' => array
    (
        'tables' => array('tl_estate_types', 'tl_estates',),
        'icon'   => 'system/modules/real-estate-manager/html/icon.gif',
    )
));

// Front end modules
array_insert($GLOBALS['FE_MOD'], 2, array
(
    'miscellaneous' => array(
        'EstateOverview' => 'Pacolu\\RealEstateBundle\\Module\\EstateManagement',
        'EstateManagement' => 'Pacolu\\RealEstateBundle\\Module\\EstateDetailsPage',
        'EstateCategory' => 'Pacolu\\RealEstateBundle\\Module\\EstateCategory',
	)
));

// Add permissions
$GLOBALS['TL_PERMISSIONS'][] = 'real-estate-manager';
