<?php

require 'vendor/autoload.php';

use \DTS\eBaySDK\Shopping\Services;
use \DTS\eBaySDK\Shopping\Types;

// Create the service object.
$service = new Services\ShoppingService(array(
    'apiVersion' => '863',
    'appId' => EBAY_APP_ID
));
//Id is root so select default categories from DB
if($_GET['id'] == -1) {
    $pdo =  new PDO('mysql:host=localhost;dbname=ebay', 'root','');
    $stmt = $pdo->prepare("SELECT * from categories");
    $stmt->execute();
    $results = $stmt->fetchAll();
} else {
// Create the request object.
    $request = new Types\GetCategoryInfoRequestType(array('CategoryID' => $_GET['id'],'IncludeSelector' => 'ChildCategories'));

// Send the request to the service operation.
    $response = $service->getCategoryInfo($request);
    $results = array();
    foreach($response->CategoryArray->Category as $category) {
        if($category->CategoryName =='Root') continue;
        array_push($results,
            array('name'=>$category->CategoryName,
                'id' => $category->CategoryID,
                'parentId'=>$category->CategoryParentID
            ));
    }

}
header('Content-Type: application/json');
echo json_encode(array('categories'=>$results));