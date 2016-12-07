<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014-2016
 */


use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$route = new Route( '/{site}/lists', array( '_controller' => 'AimeosShopBundle:Catalog:list' ) );
$collection->add( 'catalog_list', $route );

return $collection;
