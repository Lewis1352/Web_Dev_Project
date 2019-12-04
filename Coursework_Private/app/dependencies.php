<?php

// Register component on container
$container['view'] = function ($container) {
  $view = new \Slim\Views\Twig(
    $container['settings']['view']['template_path'],
    $container['settings']['view']['twig'],
    [
      'debug' => true // This line should enable debug mode
    ]
  );

  // Instantiate and add Slim specific extension
  $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
  $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

  // This line should allow the use of {{ dump() }} debugging in Twig
  $view->addExtension(new \Twig_Extension_Debug());

  return $view;
};

$container['validator'] = function ($container) {
  $validator = new \SoapClient\Validator();
  return $validator;
};

$container['companyDetailsModel'] = function ($container) {
  $model = new \SoapClient\CompanyDetailsModel();
  return $model;
};

$container['companyDetailsChartModel'] = function ($container) {
  $model = new \SoapClient\CompanyDetailsChartModel();
  return $model;
};

$container['databaseWrapper'] = function ($container) {
  $database_wrapper = new \SoapClient\DatabaseWrapper();
  return $database_wrapper;
};

$container['sqlQueries'] = function ($container) {
  $sql_queries = new \SoapClient\SQLQueries();
  return $sql_queries;
};

$container['retrieveStockDataModel'] = function ($container) {
    $retrieve_stock_data_model = new \SoapClient\RetrieveStockDataModel();
    return $retrieve_stock_data_model;
};

$container['SoapClient'] = function ($container) {
    $retrieve_stock_data_model = new \SoapClient\SoapWrapper();
    return $retrieve_stock_data_model;
};

$container['xmlParser'] = function ($container) {
    $model = new \SoapClient\XmlParser();
    return $model;
};