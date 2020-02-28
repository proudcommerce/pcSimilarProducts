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
use OxidEsales\Eshop\Core\Registry;

$sLangName = 'Deutsch';

$aLang = [
    'charset'                                  => 'UTF-8',
    'SHOP_MODULE_GROUP_pcsimilarproducts_main' => 'Allgemein',
    'SHOP_MODULE_pcsimilarproducts_attr1'      => 'Attribut 1',
    'HELP_SHOP_MODULE_pcsimilarproducts_attr1' => 'Mindestens das erste Attribut muss gewählt sein, damit die Modullogik greift. Die beiden weiteren Attribute sind optional. Bei Aktivierung erfolgt eine UND-Verknüpfung.',
    'SHOP_MODULE_pcsimilarproducts_attr2'      => 'Attribut 2',
    'SHOP_MODULE_pcsimilarproducts_attr3'      => 'Attribut 3',
    'SHOP_MODULE_pcsimilarproducts_attr1_'     => '--- nicht ausgewählt ---',
    'SHOP_MODULE_pcsimilarproducts_attr2_'     => '--- nicht ausgewählt ---',
    'SHOP_MODULE_pcsimilarproducts_attr3_'     => '--- nicht ausgewählt ---',

];

// get attribute translation
$table = getViewName('oxattribute');
$sql = 'SELECT oxid, oxtitle FROM ' . $table . ' WHERE oxshopid ORDER BY oxtitle ASC';
$attributes = DatabaseProvider::getDb()->select($sql);
foreach ($attributes as $attribute) {
    $aLang['SHOP_MODULE_pcsimilarproducts_attr1_' . $attribute[0]] = $attribute[1];
    $aLang['SHOP_MODULE_pcsimilarproducts_attr2_' . $attribute[0]] = $attribute[1];
    $aLang['SHOP_MODULE_pcsimilarproducts_attr3_' . $attribute[0]] = $attribute[1];
}
