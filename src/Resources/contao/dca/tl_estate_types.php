<?php
/**
 * Refer to LICENSE.txt distributed with the Real Estate bundle for notice of license
 */

$GLOBALS['TL_DCA']['tl_estate_types'] = array
(

    // Config
    'config'   => array
    (
        'dataContainer' => 'Table',
        'ctable'        => array('tl_estates'),
        'sql'           => array
        (
            'keys' => array
            (
                'id' => 'primary',
            )
        ),
    ), // end of config array

    // List
    'list'     => array
    (
        'sorting'           => array
        (
            'mode'        => 1,
            'fields'      => array('title DESC'),
            'flag'        => 1,
            'panelLayout' => 'search,limit',
        ),
        'label'             => array
        (
            'fields' => array('title'),
            'format' => '%s',
        ),
        'global_operations' => array
        (
            'all' => array
            (
                'label'      => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'       => 'act=select',
                'class'      => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset()" accesskey="e"',
            )
        ),
        'operations'        => array
        (
            'edit'   => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_estate_types']['edit'],
                'href'  => 'table=tl_estates',
                'icon'  => 'edit.svg',
            ),
            'copy'   => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_estate_types']['copy'],
                'href'  => 'act=copy',
                'icon'  => 'copy.svg',
            ),
            'delete' => array
            (
                'label'      => &$GLOBALS['TL_LANG']['tl_estate_types']['delete'],
                'href'       => 'act=delete',
                'icon'       => 'delete.svg',
                'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
            ),
            'show'   => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_estate_types']['show'],
                'href'  => 'act=show',
                'icon'  => 'show.svg',
            )
        )
    ), // end of list array

    // Palettes
    'palettes' => array
    (
        'default' => '{title_legend},title'
    ), // end of palettes array

    // Fields
    'fields'   => array
    (
        'id'     => array
        (
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ),
        'tstamp' => array
        (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'title'  => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_estate_types']['title'],
            'inputType' => 'text',
            'search'    => true,
            'eval'      => array('mandatory' => true, 'maxlength' => 64),
            'sql'       => "varchar(64) NOT NULL default ''",
        )
    )
);
