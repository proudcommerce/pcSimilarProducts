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

namespace ProudCommerce\SimilarProducts\Application\Model;

use OxidEsales\Eshop\Core\Registry;

/**
 * Class Article
 * @package ProudCommerce\SimilarProducts\Application\Model
 */
class Article extends Article_parent
{

    /**
     * @param $sArticleTable
     * @param $aList
     * @return string
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseErrorException
     */
    protected function _generateSimListSearchStr($sArticleTable, $aList)
    {
        $sFieldList = $this->getSelectFields();

        // ProudCommerce
        $simProducts = $this->getPcSimilarProducts();
        if (!empty($simProducts)) {
            $aList = $simProducts;
        } else {
            $aList = array_slice($aList, 0, $this->getConfig()->getConfigParam('iNrofSimilarArticles'));
        }

        $sSearch = "select $sFieldList from $sArticleTable where " . $this->getSqlActiveSnippet() . "  and $sArticleTable.oxissearch = 1 and $sArticleTable.oxid in ( ";

        $sSearch .= implode(',', \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->quoteArray($aList)) . ')';

        // #524A -- randomizing articles in attribute list
        $sSearch .= ' order by rand() ';

        return $sSearch;
    }

    /**
     * @return array
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseErrorException
     */
    protected function getPcSimilarProducts()
    {
        $oDb = \OxidEsales\Eshop\Core\DatabaseProvider::getDb();

        $attributes = $this->getPcArticleAttributes();

        if (($attribute1 = Registry::getConfig()->getConfigParam('pcsimilarproducts_attr1')) && !empty($attributes[$attribute1])) {
            $sSelect = 'select oxobjectid from oxobject2attribute where (oxattrid = "' . $attribute1 . '" and oxvalue = "' . $attributes[$attribute1] . '")';
            $articles = $oDb->getCol($sSelect);
        }
        if (($attribute2 = Registry::getConfig()->getConfigParam('pcsimilarproducts_attr1')) && !empty($attributes[$attribute2])) {
            $sSelect = 'select oxobjectid from oxobject2attribute where oxattrid = "' . $attribute2 . '" and oxvalue = "' . $attributes[$attribute2] . '" and oxobjectid in ("' . implode('", "', $articles) . '")';
            $articles = $oDb->getCol($sSelect);
        }
        if (($attribute3 = Registry::getConfig()->getConfigParam('pcsimilarproducts_attr1')) && !empty($attributes[$attribute3])) {
            $sSelect = 'select oxobjectid from oxobject2attribute where oxattrid = "' . $attribute3 . '" and oxvalue = "' . $attributes[$attribute3] . '" and oxobjectid in ("' . implode('", "', $articles) . '")';
            $articles = $oDb->getCol($sSelect);
        }

        return $articles;
    }

    /**
     * @return mixed
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseErrorException
     */
    protected function getPcArticleAttributes()
    {
        $oDb = \OxidEsales\Eshop\Core\DatabaseProvider::getDb(\OxidEsales\Eshop\Core\DatabaseProvider::FETCH_MODE_ASSOC);
        $sSelect = 'select oxattrid, oxvalue from oxobject2attribute where oxobjectid = "' . $this->getId() . '"';
        $attributes = $oDb->getAll($sSelect);
        foreach ($attributes as $attribute) {
            $data[$attribute['oxattrid']] = $attribute['oxvalue'];
        }
        return $data;
    }

}
