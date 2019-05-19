<?php
$GLOBALS['request']="";
$GLOBALS['response']=json_decode(file_get_contents('response.json'),true);
$GLOBALS['parameters']="";

function resolveMenuSearchParameters(){
  $GLOBALS['parameters']=$GLOBALS['request']['queryResult']['parameters'];
  if ($GLOBALS['parameters']['food_timing']=="") {
    $GLOBALS['parameters']['food_timing']=foodTimingsResolver();
  }

  if ($GLOBALS['parameters']['gender']=="") {
    $GLOBALS['parameters']['gender']="male";
  }

  if (strlen($GLOBALS['parameters']['date'])<4) {
    $GLOBALS['parameters']['date']=date("Y-m-d");
  }

  $GLOBALS['parameters']['day_of_week']=date('N', strtotime(substr($GLOBALS['parameters']['date'],0,10)))-1;
}

function foodTimingsResolver(){
  $currentSystemTime=date("H:i:m");
  $timing="breakfast";
  if ($currentSystemTime>"22:30:00" && $currentSystemTime<"10:00:00") {
    $timing="breakfast";
  } elseif ($currentSystemTime>"10:00:00" && $currentSystemTime<"14:00:00") {
    $timing="lunch";
  } elseif ($currentSystemTime>"14:00:00" && $currentSystemTime<"18:00:00") {
    $timing="snacks";
  } elseif ($currentSystemTime>"18:00:00" && $currentSystemTime<"22:30:00") {
    $timing="dinner";
  }
  return $timing;
}

function getMenuForParameters(){
  require $_SERVER['DOCUMENT_ROOT']."/actions/hostelchef/v0.2/dbconmenu.php";
  $stmtgetMenuForParam->execute();
  $stmtgetMenuForParam->setFetchMode(PDO::FETCH_ASSOC);
  $result=$stmtgetMenuForParam->fetchAll();
  $timing=$GLOBALS['parameters']['food_timing'];
  $splits=explode(",", $result[0]["$timing"]);
  for ($i=0; $i < count($splits) ; $i++) {
    $item_id=trim($splits[$i], " ");
    $stmtgetItemForMenu->execute();
    $stmtgetItemForMenu->setFetchMode(PDO::FETCH_ASSOC);
    $result=$stmtgetItemForMenu->fetchAll();
    $GLOBALS['menu'][$i]['item_id']=$result[0]['item_id'];
    $GLOBALS['menu'][$i]['name']=$result[0]['name'];
    $GLOBALS['menu'][$i]['type']=$result[0]['type'];
  }
  return TRUE;
}
function prepareMenuResponse(){
  require $_SERVER['DOCUMENT_ROOT']."/way-to-db-connection-file";
  $speechResponse="";

  if (count($GLOBALS['menu'])>1) {
    for ($i=0; $i <count($GLOBALS['menu']) ; $i++) {
      $GLOBALS['response']['payload']['google']['richResponse']['items'][1]['carouselBrowse']['items'][$i]['title']=$GLOBALS['menu'][$i]['name'];
      $GLOBALS['response']['payload']['google']['richResponse']['items'][1]['carouselBrowse']['items'][$i]['openUrlAction']['url']="https://www.google.com/search?q=".$GLOBALS['menu'][$i]['name'];
      $GLOBALS['response']['payload']['google']['richResponse']['items'][1]['carouselBrowse']['items'][$i]['footer']=$GLOBALS['menu'][$i]['type']==1? "non-veg": "veg";
      $GLOBALS['response']['payload']['google']['richResponse']['items'][1]['carouselBrowse']['items'][$i]['image']['url']="https://dsccu.in/actions/hostelchef/img/sized/".$GLOBALS['menu'][$i]['item_id'].".jpg";
      $GLOBALS['response']['payload']['google']['richResponse']['items'][1]['carouselBrowse']['items'][$i]['image']['accessibilityText']=$GLOBALS['menu'][$i]['name'];
      $speechResponse.=$GLOBALS['menu'][$i]['name'].", ";
    }
    $GLOBALS['response']['payload']['google']['richResponse']['items'][0]['simpleResponse']['displayText']=$textResponse;
    $GLOBALS['response']['payload']['google']['richResponse']['items'][0]['simpleResponse']['textToSpeech']=$speechResponse;
    //$GLOBALS['response']['payload']['google']['expectUserResponse']=false;
  }else{

  }
}

function resolveItemSearchParameters(){
  $GLOBALS['parameters']=$GLOBALS['request']['queryResult']['parameters'];

  if ($GLOBALS['parameters']['gender']=="") {
    $GLOBALS['parameters']['gender']="male";
  }
}


function getServingsForItem(){
  require $_SERVER['DOCUMENT_ROOT']."/way-to-db-connection-file";
  $stmtgetItemForItemId->execute();
  $stmtgetItemForItemId->setFetchMode(PDO::FETCH_ASSOC);
  $result=$stmtgetItemForItemId->fetchAll();
  $GLOBALS['parameters']['item_name']=$result[0]["name"];
  $stmtgetServingsForItem->execute();
  $stmtgetServingsForItem->setFetchMode(PDO::FETCH_ASSOC);
  $result=$stmtgetServingsForItem->fetchAll();

  $GLOBALS['servings']=array();
  $servingCount=0;
  for ($i=0; $i < count($result) ; $i++) {
    $found=false;
    $timings="";
    $menu=explode(",",$result[$i]['breakfast']);
    for ($j=0; $j <count($menu) ; $j++) {
      if (trim($menu[$j], " ")==$GLOBALS['parameters']['items']) {
        $found=TRUE;
        $timings.=" breakfast,";
        break;
      }
    }

    $menu=explode(",",$result[$i]['lunch']);
    for ($j=0; $j <count($menu) ; $j++) {
      if (trim($menu[$j], " ")==$GLOBALS['parameters']['items']) {
        $found=TRUE;
        $timings.=" lunch,";
        break;
      }
    }

    $menu=explode(",",$result[$i]['snacks']);
    for ($j=0; $j <count($menu) ; $j++) {
      if (trim($menu[$j], " ")==$GLOBALS['parameters']['items']) {
        $found=TRUE;
        $timings.=" snacks,";
        break;
      }
    }

    $menu=explode(",",$result[$i]['dinner']);
    for ($j=0; $j <count($menu) ; $j++) {
      if (trim($menu[$j], " ")==$GLOBALS['parameters']['items']) {
        $found=TRUE;
        $timings.="dinner. ";
        break;
      }
    }

    if ($found) {
      $GLOBALS['servings'][$servingCount]['day_id']=$result[$i]['day_id'];
      $GLOBALS['servings'][$servingCount]['timings']=$timings;
      $servingCount++;
    }
  }
  //var_dump($GLOBALS['servings']);
  return TRUE;
}

function prepareServingsResponse(){
  $days=array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
  $textResponse="Schedule for ".$GLOBALS['parameters']['item_name'];
  $speechResponse="Let's see.. ";

  if (count($GLOBALS['servings'])>1) {
    for ($i=0; $i <count($GLOBALS['servings']) ; $i++) {
      $GLOBALS['response']['payload']['google']['richResponse']['items'][1]['carouselBrowse']['items'][$i]['title']=$days[$GLOBALS['servings'][$i]['day_id']];
      $GLOBALS['response']['payload']['google']['richResponse']['items'][1]['carouselBrowse']['items'][$i]['openUrlAction']['url']="https://www.google.com/search?q=".$GLOBALS['parameters']['item_name'];
      $GLOBALS['response']['payload']['google']['richResponse']['items'][1]['carouselBrowse']['items'][$i]['footer']=substr_replace($GLOBALS['servings'][$i]['timings'], "", -1);
      $GLOBALS['response']['payload']['google']['richResponse']['items'][1]['carouselBrowse']['items'][$i]['image']['url']="https://dsccu.in/actions/hostelchef/img/sized/".$GLOBALS['parameters']['items'].".jpg";
      $GLOBALS['response']['payload']['google']['richResponse']['items'][1]['carouselBrowse']['items'][$i]['image']['accessibilityText']=$GLOBALS['parameters']['item_name'];
      $speechResponse.=$days[$GLOBALS['servings'][$i]['day_id']].", ";
    }
    $GLOBALS['response']['payload']['google']['richResponse']['items'][0]['simpleResponse']['displayText']=$textResponse;
    $GLOBALS['response']['payload']['google']['richResponse']['items'][0]['simpleResponse']['textToSpeech']=$speechResponse;
  }elseif(count($GLOBALS['servings'])==1){
    $GLOBALS['response']['payload']['google']['richResponse']['items'][1]['basicCard']['title']=$days[$GLOBALS['servings'][0]['day_id']];
    $GLOBALS['response']['payload']['google']['richResponse']['items'][1]['basicCard']['openUrlAction']['url']="https://www.google.com/search?q=".$GLOBALS['parameters']['item_name'];
    $GLOBALS['response']['payload']['google']['richResponse']['items'][1]['basicCard']['subtitle']=$GLOBALS['servings'][0]['timings'];
    $GLOBALS['response']['payload']['google']['richResponse']['items'][1]['basicCard']['formattedText']="";
    $GLOBALS['response']['payload']['google']['richResponse']['items'][1]['basicCard']['image']['url']="https://dsccu.in/actions/hostelchef/img/sized/".$GLOBALS['parameters']['items'].".jpg";
    $GLOBALS['response']['payload']['google']['richResponse']['items'][1]['basicCard']['image']['accessibilityText']=$GLOBALS['parameters']['item_name'];

    $speechResponse.="Only on ".$days[$GLOBALS['servings'][0]['day_id']];
    $GLOBALS['response']['payload']['google']['richResponse']['items'][0]['simpleResponse']['displayText']=$textResponse;
    $GLOBALS['response']['payload']['google']['richResponse']['items'][0]['simpleResponse']['textToSpeech']=$speechResponse;
    
    //$GLOBALS['response']['payload']['google']['expectUserResponse']=false;

  }

}


#Start of Program

if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $requestBody = file_get_contents('php://input');
  $GLOBALS['request']= json_decode($requestBody,true);
  if ($GLOBALS['request']['queryResult']['intent']['displayName']=="Item Search") {
    resolveItemSearchParameters();
    if (getServingsForItem()) {
      prepareServingsResponse();
    }
  }elseif ($GLOBALS['request']['queryResult']['intent']['displayName']=="Menu Search") {
    resolveMenuSearchParameters();
    if(getMenuForParameters()){
      prepareMenuResponse();
    }
  }
}else{
  echo $_SERVER['REQUEST_METHOD'];
}
echo json_encode($GLOBALS['response']);
?>
