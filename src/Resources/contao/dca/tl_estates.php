<?php
/**
 * Refer to LICENSE.txt distributed with the Real Estate bundle for notice of license
 */

$GLOBALS['TL_DCA']['tl_estates'] = array
(

    // Config
    'config'   => array
    (
        'dataContainer' => 'Table',
        'ptable'        => 'tl_estate_types',
        'sql'           => array
        (
            'keys' => array
            (
                'id'  => 'primary',
                'pid' => 'index'
            )
        ),
    ),

    // List
    'list'     => array
    (
        'sorting'           => array
        (
            'mode'                  => 4,
            'fields'                => array('published DESC'),
            'flag'                  => 1,
            'headerFields'          => array('title'),
            'panelLayout'           => 'search,limit',
            'child_record_callback' => array('tl_estates', 'showEstateList')
        ),
        'global_operations' => array
        (
            'all' => array
            (
                'label'      => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'       => 'act=select',
                'class'      => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset()" accesskey="e"'
            )
        ),
        'operations'        => array
        (
            'edit'   => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_estates']['edit'],
                'href'  => 'act=edit',
                'icon'  => 'edit.svg'
            ),
            'copy'   => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_estates']['copy'],
                'href'  => 'act=copy',
                'icon'  => 'copy.svg'
            ),
            'delete' => array
            (
                'label'      => &$GLOBALS['TL_LANG']['tl_estates']['delete'],
                'href'       => 'act=delete',
                'icon'       => 'delete.svg',
                'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            ),
            'show'   => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_estates']['show'],
                'href'  => 'act=show',
                'icon'  => 'show.svg'
            )
        )
    ), // end of list array

    // Palettes
    'palettes' => array
    (
        'default' => '
    {title_legend},title,type,expose;
    {adress_legend},location,floor,number_of_floors,shared_flat;
    {information_legend},date,rooms,condition,year_of_construction,living_space,heating,balcony,pets,pitch,energy_certificate;
    {miet_legend},bail,cold_rent,warm_rent,additional_costs,heating_cost,usable_area,number_of_bedrooms,number_of_bathrooms,kitchen,bath;
    {kauf_legend},purchase_price,commission,plot_area,rental_income,x_times_rent;
    {extra_legend},available,visit,information,object_id,immonet_number,display_picture,gallery,expose_pdf;
    {referenz_legend},services;
    {published_legend},published'
    ),

    // Fields
    'fields'   => array
    (
        'id'                   => array
        (
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ),
        'pid'                  => array
        (
            'foreignKey' => 'tl_estate_types.id',
            'sql'        => "int(10) unsigned NOT NULL default '0'",
            'relation'   => array('type' => 'belongsTo', 'load' => 'lazy')
        ),
        'tstamp'               => array
        (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'title'                => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_estates']['title'],
            'inputType' => 'text',
            'search'    => true,
            'eval'      => array('mandatory' => true, 'maxlength' => 64, 'tl_class' => 'w50'),
            'sql'       => "varchar(64) NOT NULL default ''"
        ),
        'type'                 => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_estates']['type'],
            'inputType' => 'text',
            'search'    => true,
            'eval'      => array('mandatory' => true, 'maxlength' => 64, 'tl_class' => 'w50'),
            'sql'       => "varchar(64) NOT NULL default ''"
        ),
        'expose'               => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_estates']['expose'],
            'inputType' => 'text',
            'eval'      => array('mandatory' => true, 'maxlength' => 64, 'tl_class' => 'w50', 'unique' => true),
            'sql'       => "varchar(64) NOT NULL default ''"
        ),
        'location'             => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_estates']['location'],
            'inputType' => 'textarea',
            'eval'      => array('mandatory' => true, 'rte' => 'tinyMCE', 'tl_class' => 'w100'),
            'sql'       => "text NULL"
        ),
        'floor'                => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_estates']['floor'],
            'inputType' => 'text',
            'eval'      => array('maxlength' => 64, 'tl_class' => 'w50'),
            'sql'       => "varchar(64) NOT NULL default ''"
        ),
        'number_of_floors'     => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_estates']['number_of_floors'],
            'inputType' => 'text',
            'eval'      => array('maxlength' => 64, 'tl_class' => 'w50'),
            'sql'       => "varchar(64) NOT NULL default ''"
        ),
        'shared_flat'          => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_estates']['shared_flat'],
            'inputType' => 'text',
            'eval'      => array('maxlength' => 64, 'tl_class' => 'w100'),
            'sql'       => "varchar(64) NOT NULL default ''"
        ),
        'date'                 => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_estates']['date'],
            'default'   => time(),
            'exclude'   => true,
            'filter'    => true,
            'sorting'   => true,
            'flag'      => 8,
            'inputType' => 'text',
            'eval'      => array('rgxp' => 'date', 'doNotCopy' => true, 'datepicker' => true, 'tl_class' => 'w50 wizard', 'mandatory' => true),
            'sql'       => "int(10) unsigned NOT NULL default '0'"
        ),
        'rooms'                => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_estates']['rooms'],
            'inputType' => 'text',
            'eval'      => array('maxlength' => 64, 'tl_class' => 'w50'),
            'sql'       => "varchar(64) NOT NULL default ''"
        ),
        'condition'            => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_estates']['condition'],
            'inputType' => 'text',
            'eval'      => array('maxlength' => 64, 'tl_class' => 'w50'),
            'sql'       => "varchar(64) NOT NULL default ''"
        ),
        'year_of_construction' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_estates']['year_of_construction'],
            'inputType' => 'text',
            'eval'      => array('maxlength' => 64, 'tl_class' => 'w50'),
            'sql'       => "varchar(64) NOT NULL default ''"
        ),
        'pets'                 => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_estates']['pets'],
            'inputType' => 'text',
            'eval'      => array('maxlength' => 64, 'tl_class' => 'w50'),
            'sql'       => "varchar(64) NOT NULL default ''"
        ),
        'pitch'                => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_estates']['pitch'],
            'inputType' => 'text',
            'eval'      => array('maxlength' => 128, 'tl_class' => 'w100'),
            'sql'       => "varchar(128) NOT NULL default ''"
        ),
        'energy_certificate'   => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_estates']['energy_certificate'],
            'inputType' => 'fileTree',
            'eval'      => array('fieldType' => 'radio', 'files' => true, 'filesOnly' => true, 'extensions' => 'pdf'),
            'sql'       => "binary(16) NULL"
        ),
        'bail'                 => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_estates']['bail'],
            'inputType' => 'text',
            'eval'      => array('maxlength' => 64, 'tl_class' => 'w50'),
            'sql'       => "varchar(64) NOT NULL default ''"
        ),
        'cold_rent'            => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_estates']['cold_rent'],
            'inputType' => 'text',
            'eval'      => array('maxlength' => 64, 'tl_class' => 'w50'),
            'sql'       => "varchar(64) NOT NULL default ''"
        ),
        'warm_rent'            => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_estates']['warm_rent'],
            'inputType' => 'text',
            'eval'      => array('maxlength' => 64, 'tl_class' => 'w50'),
            'sql'       => "varchar(64) NOT NULL default ''"
        ),
        'additional_costs'     => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_estates']['additional_costs'],
            'inputType' => 'text',
            'eval'      => array('maxlength' => 64, 'tl_class' => 'w50'),
            'sql'       => "varchar(64) NOT NULL default ''"
        ),
        'heating_cost'         => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_estates']['heating_cost'],
            'inputType' => 'text',
            'eval'      => array('maxlength' => 64, 'tl_class' => 'w50'),
            'sql'       => "varchar(64) NOT NULL default ''"
        ),
        'living_space'         => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_estates']['living_space'],
            'inputType' => 'text',
            'eval'      => array('maxlength' => 64, 'tl_class' => 'w50'),
            'sql'       => "varchar(64) NOT NULL default ''"
        ),
        'usable_area'          => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_estates']['usable_area'],
            'inputType' => 'text',
            'eval'      => array('maxlength' => 64, 'tl_class' => 'w50'),
            'sql'       => "varchar(64) NOT NULL default ''"
        ),
        'heating'              => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_estates']['heating'],
            'inputType' => 'text',
            'eval'      => array('maxlength' => 64, 'tl_class' => 'w50'),
            'sql'       => "varchar(64) NOT NULL default ''"
        ),
        'number_of_bedrooms'   => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_estates']['number_of_bedrooms'],
            'inputType' => 'text',
            'eval'      => array('maxlength' => 64, 'tl_class' => 'w50'),
            'sql'       => "varchar(64) NOT NULL default ''"
        ),
        'number_of_bathrooms'  => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_estates']['number_of_bathrooms'],
            'inputType' => 'text',
            'eval'      => array('maxlength' => 64, 'tl_class' => 'w50'),
            'sql'       => "varchar(64) NOT NULL default ''"
        ),
        'kitchen'              => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_estates']['kitchen'],
            'inputType' => 'text',
            'eval'      => array('maxlength' => 64, 'tl_class' => 'w50'),
            'sql'       => "varchar(64) NOT NULL default ''"
        ),
        'balcony'              => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_estates']['balcony'],
            'inputType' => 'text',
            'eval'      => array('maxlength' => 64, 'tl_class' => 'w50'),
            'sql'       => "varchar(64) NOT NULL default ''"
        ),
        'bath'                 => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_estates']['bath'],
            'inputType' => 'text',
            'eval'      => array('maxlength' => 64, 'tl_class' => 'w50'),
            'sql'       => "varchar(64) NOT NULL default ''"
        ),
        'purchase_price'       => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_estates']['purchase_price'],
            'inputType' => 'text',
            'eval'      => array('maxlength' => 64, 'tl_class' => 'w50'),
            'sql'       => "varchar(64) NOT NULL default ''"
        ),
        'commission'           => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_estates']['commission'],
            'inputType' => 'text',
            'eval'      => array('maxlength' => 64, 'tl_class' => 'w50'),
            'sql'       => "varchar(64) NOT NULL default ''"
        ),
        'plot_area'            => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_estates']['plot_area'],
            'inputType' => 'text',
            'eval'      => array('maxlength' => 64, 'tl_class' => 'w50'),
            'sql'       => "varchar(64) NOT NULL default ''"
        ),
        'x_times_rent'         => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_estates']['x_times_rent'],
            'inputType' => 'text',
            'eval'      => array('maxlength' => 64, 'tl_class' => 'w50'),
            'sql'       => "varchar(64) NOT NULL default ''"
        ),
        'rental_income'        => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_estates']['rental_income'],
            'inputType' => 'text',
            'eval'      => array('maxlength' => 64, 'tl_class' => 'w50'),
            'sql'       => "varchar(64) NOT NULL default ''"
        ),
        'available'            => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_estates']['available'],
            'inputType' => 'text',
            'eval'      => array('datepicker' => true, 'tl_class' => 'w50 wizard'),
            'sql'       => "varchar(64) NOT NULL default ''"
        ),
        'visit'                => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_estates']['visit'],
            'inputType' => 'text',
            'eval'      => array('datepicker' => true, 'tl_class' => 'w50 wizard'),
            'sql'       => "varchar(64) NOT NULL default ''"
        ),
        'information'          => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_estates']['information'],
            'inputType' => 'textarea',
            'eval'      => array('rte' => 'tinyMCE', 'tl_class' => 'w100'),
            'sql'       => "text NULL"
        ),
        'object_id'            => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_estates']['object_id'],
            'inputType' => 'text',
            'eval'      => array('maxlength' => 64, 'tl_class' => 'w50'),
            'sql'       => "varchar(64) NOT NULL default ''"
        ),
        'immonet_number'       => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_estates']['immonet_number'],
            'inputType' => 'text',
            'eval'      => array('maxlength' => 64, 'tl_class' => 'w50'),
            'sql'       => "varchar(64) NOT NULL default ''"
        ),
        'display_picture'      => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_estates']['display_picture'],
            'inputType' => 'fileTree',
            'eval'      => array('fieldType' => 'radio', 'files' => true, 'filesOnly' => true, 'extensions' => Contao\Config::get('validImageTypes')),
            'sql'       => "binary(16) NULL"
        ),
        'gallery'              => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_estates']['gallery'],
            'inputType' => 'fileTree',
            'eval'      => array('fieldType' => 'checkbox', 'multiple' => true, 'files' => true, 'filesOnly' => true, 'extensions' => Contao\Config::get('validImageTypes')),
            'sql'       => "blob NULL"
        ),
        'expose_pdf'           => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_estates']['expose_pdf'],
            'inputType' => 'fileTree',
            'eval'      => array('fieldType' => 'radio', 'files' => true, 'filesOnly' => true, 'extensions' => 'pdf'),
            'sql'       => "binary(16) NULL"
        ),
        'services'             => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_estates']['services'],
            'inputType' => 'textarea',
            'eval'      => array('rte' => 'tinyMCE', 'tl_class' => 'w100'),
            'sql'       => "text NULL"
        ),
        'published'            => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_estates']['published'],
            'exclude'   => true,
            'filter'    => true,
            'flag'      => 1,
            'inputType' => 'checkbox',
            'eval'      => array('doNotCopy' => true),
            'sql'       => "char(1) NOT NULL default ''"
        ),
    )
);

class tl_estates extends Backend
{

    /**
     * List objects of our collection
     * @param array
     * @return string
     */
    public function showEstateList($arrRow)
    {
        /** @var FilesModel $objFile */
        $filePath = \FilesModel::findByUuid($arrRow['display_picture']);
        if (is_file(System::getContainer()->getParameter('kernel.project_dir') . '/' . $filePath->path)) {
            $sidebar = '<img src="' . $filePath->path . '" style="height:100px; width:100px; float:left; margin-right: 1em;" />';
        } else {
            $sidebar = '<div style="display:inline-block;height:100px; width:100px; margin-right: 1em; float:left;"></div>';
        }

        return '<div>' . $sidebar . '<p><strong > ' . $arrRow['type'] . ' </strong > <br > ' . $arrRow['title'] . ' </p>
    <span > ' . $arrRow['expose'] . ' </span >
    </div >' . "\n";
    }

}
