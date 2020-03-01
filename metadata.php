<?php
/**
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @package pcSimilarProducts
 * @copyright ProudCommerce
 * @link www.proudcommerce.com
 **/

use OxidEsales\Eshop\Core\DatabaseProvider;

/**
 * Metadata version
 */
$sMetadataVersion = '2.0';

if (!function_exists('getPcAttributesList')) {
    function getPcAttributesList()
    {
        $table = getViewName('oxattribute');
        $sql = 'SELECT oxid FROM ' . $table . ' WHERE oxshopid ORDER BY oxtitle ASC';
        $attributes = DatabaseProvider::getDb()->select($sql);
        $attributesList[] = '';
        foreach ($attributes as $attribute) {
            $attributesList[] = $attribute[0];
        }
        return $attributesList;
    }
}
$pcAttributesList = getPcAttributesList();


/**
 * Module information
 */
$aModule = [
    'id'          => 'pcSimilarProducts',
    'title'       => 'pcSimilarProducts',
    'description' => [
        'de' => 'Verbesserte Logik zur Anzeige von ähnlichen Artikeln.',
        'en' => 'Better logic for displaying similar products.',
    ],
    'thumbnail'   => '',
    'version'     => '1.0.1',
    'author'      => 'ProudCommerce',
    'url'         => 'https://www.proudcommerce.com',
    'email'       => 'module@proudcommerce.com',
    'controllers' => [
    ],

    'extend' => [
        \OxidEsales\Eshop\Application\Model\Article::class => \ProudCommerce\SimilarProducts\Application\Model\Article::class,
    ],

    'templates' => [
    ],

    'blocks' => [
    ],

    'settings' => [
        ['group' => 'pcsimilarproducts_main', 'name' => 'pcsimilarproducts_attr1', 'type' => 'select', 'constrains' => implode('|', $pcAttributesList)],
        ['group' => 'pcsimilarproducts_main', 'name' => 'pcsimilarproducts_attr2', 'type' => 'select', 'constrains' => implode('|', $pcAttributesList)],
        ['group' => 'pcsimilarproducts_main', 'name' => 'pcsimilarproducts_attr3', 'type' => 'select', 'constrains' => implode('|', $pcAttributesList)],
    ],

    'events' => [
    ],
];
