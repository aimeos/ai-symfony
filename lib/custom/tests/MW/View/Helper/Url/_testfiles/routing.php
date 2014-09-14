<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$route = new Route( '/list', array( '_controller' => 'AimeosShopBundle:Catalog:list' ) );
$collection->add( 'catalog_list', $route );

return $collection;
