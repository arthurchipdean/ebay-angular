<?php
include 'vendor/autoload.php';
$pdo =  new PDO('mysql:host=localhost;dbname=ebay', 'root','');
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"),true);
    $valid_fields = array_flip(array('id','user_id', 'name', 'q',  'sort', 'category', 'freeShipping', 'MinBid', 'MaxBid', 'MinPrice', 'MaxPrice', 'Auction', 'FixedPrice'));
    $fields = array_intersect_key($data, $valid_fields);

    if(isset($fields['id'])) {
        $q = "UPDATE saved_search_settings SET ";
        $list = array();
        foreach($fields as $k=>$v)
            $list[]="$k = '$v'";
        $q.= implode(',', $list). " WHERE id={$fields['id']}";
    }
    else
        $q = "INSERT INTO saved_search_settings (". implode(',',array_keys($fields)).") VALUES ('".implode("','",$fields)."')";
    $stmt = $pdo->prepare($q);
    $stmt->execute();
    echo $q;
}
else {
    $stmt = $pdo->prepare("SELECT * FROM saved_search_settings");
    $stmt->execute();
    echo json_encode(array('saved_searches' => $stmt->fetchAll()));
}
