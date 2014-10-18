<?php
require 'vendor/autoload.php';

use \DTS\eBaySDK\Constants;
use \DTS\eBaySDK\Finding\Services;
use \DTS\eBaySDK\Finding\Types;
use DTS\eBaySDK\Finding\Types\ItemFilter;
use DTS\eBaySDK\Finding\Types\PaginationInput;


$service = new Services\FindingService(array(
    'appId' => EBAY_APP_ID,
    'globalId' => Constants\GlobalIds::US
));
if(isset($_GET['category'])) {
    $request = new Types\FindItemsAdvancedRequest();
    $request->categoryId = array($_GET['category']);
}
else
    $request = new Types\FindItemsByKeywordsRequest();
if(isset($_GET['MinBids']))
    $request->itemFilter[]= new ItemFilter(array('name'=> 'MinBids', 'value' => array($_GET['MinBids'])));
if(isset($_GET['MaxBids']))
    $request->itemFilter[]= new ItemFilter(array('name'=> 'MaxBids', 'value' => array($_GET['MaxBids'])));
if(isset($_GET['MinPrice']))
    $request->itemFilter[]= new ItemFilter(array('name'=> 'MinPrice', 'value' => array($_GET['MinPrice'])));
if(isset($_GET['MaxPrice']))
    $request->itemFilter[]= new ItemFilter(array('name'=> 'MaxPrice', 'value' => array($_GET['MaxPrice'])));

if(isset($_GET['sort']))
    $request->sortOrder = $_GET['sort'];
if(isset($_GET['page'])) {
    $request->paginationInput = new PaginationInput();
    $request->paginationInput->pageNumber = (int)$_GET['page'];
}
if(isset($_GET['freeShipping']) && $_GET['freeShipping'])
    $request->itemFilter []= new ItemFilter(array('name'=>'FreeShippingOnly','value' => array('true')));

if(isset($_GET['Auction']) || isset($_GET['BuyNow'])) {
    $auction_types = array();
    if(isset($_GET['Auction']) && $_GET['Auction'])
        $auction_types[]='Auction';
    if(isset($_GET['BuyNow']) && $_GET['BuyNow'])
        $auction_types[]='FixedPrice';
    $request->itemFilter[]= new ItemFilter(array('name'=>'ListingType','value'=>$auction_types));
}

$request->keywords = $_GET['q'];






if(isset($_GET['category']))
    $response = $service->findItemsAdvanced($request);
else
    $response = $service->findItemsByKeywords($request);

$result = array();
$now = new DateTime();
foreach ($response->searchResult->item as $item) {
    $interval = $item->listingInfo->endTime->diff($now);
    array_push($result, array(
        'id' =>           $item->itemId,
        'title' =>        $item->title,
        'buyItPrice' =>   $item->listingInfo->buyItNowPrice,
        'image' =>        $item->galleryURL,
        'shipping' =>     $item->shippingInfo->shippingType,
        'subtitle' =>     $item->subtitle,
        'location' =>     $item->location,
        'url' =>          $item->viewItemURL,
        'currency' =>     $item->sellingStatus->currentPrice->currencyId,
        'value' =>        $item->sellingStatus->currentPrice->value,
        'remaining' => $interval->format("%d days, %h hours, %i minutes, %s seconds"),
        'topRated' => $item->topRatedListing
    ));
}
header('Content-Type: application/json');
echo json_encode(array('results' => $result, 'count' =>$response->paginationOutput->totalEntries,'page' =>$response->paginationOutput->pageNumber ));