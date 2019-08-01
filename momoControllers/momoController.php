<?php

class Momo{

   private $shop_id;
   private $open_key;
   private $manager_key;

  public function __construct(){
    $this->shop_id = "eat584.ev";
    $this->open_key = "56967090a3ccdd49e066c5b6c92d491edb7df42c";
    $this->manager_key = "9f091d99c504e977f780f777910c1ef5b9aa748f";
  }

  //GET
  public function get($url){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_USERPWD, $this->shop_id.":".$this->manager_key);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//문자열로 바꾸기
    $result = curl_exec($curl);//결과 result 변수에 저장
    curl_errno($curl);
    curl_close($curl);
    $data_json =  json_decode($result, true);//배열로 바꾸기
  }

  //POST
  public function post($url,$data){

    if(gettype($data) == 'array'){
        $data = json_encode($data); // array -> json
    }

        //$data = json_encode($data); // array -> json
    $curl = curl_init(); // RESET
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: json'));
    //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);     // 원격서버의 인증서가 유효한지 검사 안함
    curl_setopt($curl, CURLOPT_USERPWD, $this->shop_id.":".$this->manager_key);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result  = curl_exec($curl);
    curl_errno($curl);
    curl_close($curl);
    $return_data =  json_decode($result, true);//배열로 바꾸기

    return $return_data;
  }

  //PUT
  public function put($url,$item_data){

    $data_json = json_encode($item_data,JSON_UNESCAPED_UNICODE);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_json)));
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($curl, CURLOPT_POSTFIELDS,$data_json);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_USERPWD, $this->shop_id.":".$this->manager_key);
    $result  = curl_exec($curl);
    curl_errno($curl);
    curl_close($curl);
    $return_data =  json_decode($result, true);

  }

  //商品基本情報
  public function itemInformation(){
    $item_code = $_POST['item_code'];
    $url = "https://management.api.shopserve.jp/v2/items/$item_code/basic";
    $this->get($url);

  }

  //商品登録
  public function itemRegistration(){
    //商品登録(code,name)
    $item_code = $_POST['item_code'];
    $item_name = $_POST['item_name'];

    $item_data = array('item_code'=>$item_code,
                       'item_name'=>$item_name);

    $url = "https://management.api.shopserve.jp/v2/items";

    $this->put($url,$item_data);

    //商品登録(ect.)
    $consumption_tax_setting = $_POST['consumption_tax_setting'];
    $item_price = $_POST['item_price'];
    $item_unit = $_POST['item_unit'];
    $memo = $_POST['memo'];

    $item_ect_data = array(
                            'item_name'=>$item_name,
                            'consumption_tax_setting'=>$consumption_tax_setting,
                            'item_price'=>(int)$item_price,
                            'item_unit'=>$item_unit,
                            'memo'=>$memo);
     $url = "https://management.api.shopserve.jp/v2/items/$item_code/basic";
     $this->put($url,$item_ect_data);

     echo "<script>alert('商品登録完了');";
     echo "document.location.href=\"/momo/momoViews/itemRegistration.php\";</script>";


     //商品登録(カテゴリ)
     $item_category = $_POST['item_category'];

     $item_category_words = array();
     $item_category_words = explode('>',$item_category);

     $num = (int)sizeof($item_category_words);

     for($i = 0; $i < count($item_category_words); $i++){
       $array["category"][$i] = $item_category_words[$i];
     }
     $array = array(
       "categories" => [$array]
     );
     $url = "https://management.api.shopserve.jp/v2/items/$item_code/categories";
     $this->put($url,$array);

    //商品配送情報更新
    $bundle_packing = $_POST['bundle_packing'];
    if($_POST['delivery_type']){
      $delivery_type = $_POST['delivery_type'];
    }
    else{
      $delivery_type = "Standard";
    }
    if($_POST['enable_specific_shipping_charge']){
      $enable_specific_shipping_charge = $_POST['enable_specific_shipping_charge'];
    }
    else{
      $enable_specific_shipping_charge = "No";
    }
    if($_POST['display_type']){
      $display_type = $_POST['display_type'];
    }
    else{
      $display_type = "Free";
    }

    if($_POST['prior']){
      $prior = $_POST['prior'];
    }
    else{
      $prior = "No";
    }

    if($_POST['temperature_controlled1']){
      $temperature_controlled = "Cold";
    }
    else if($_POST['temperature_controlled2']){
      $temperature_controlled = "Freeze";
    }
    else{
      $temperature_controlled = "NoControl";
    }

    if($_POST['specific_shipping_charge']){
      $specific_shipping_charge = $_POST['specific_shipping_charge'];
    }
    else{
      $specific_shipping_charge = 0;
    }
    if($delivery_type == "Mail"){
    $delivery_data = array(
                            'bundle_packing'=>$bundle_packing,
                            'delivery_type'=>$delivery_type);
    }
    else if($enable_specific_shipping_charge == "No"){
      $delivery_data = array(
                              'bundle_packing'=>$bundle_packing,
                              'delivery_type'=>$delivery_type,
                              'enable_specific_shipping_charge'=>$enable_specific_shipping_charge,
                              'temperature_controlled'=>$temperature_controlled);
    }
    else if($enable_specific_shipping_charge == "Yes"){
      $delivery_data = array(
                              'bundle_packing'=>$bundle_packing,
                              'delivery_type'=>$delivery_type,
                              'enable_specific_shipping_charge'=>'Yes', //$enable_specific_shipping_charge
                              'specific_shipping_charge'=>(int)$specific_shipping_charge,
                              'temperature_controlled'=>$temperature_controlled,
                              'display_type'=>$display_type);
    }

    $url = "https://management.api.shopserve.jp/v2/items/$item_code/shipping";
    $this->put($url,$delivery_data);

    //画像登録
    $image_name = $_POST['image_name'];
    $is_main = $_POST['is_main'];

    $image_data = array(
      "image_name"=>$image_name,
      "is_main"=>$is_main
    );
    $image_array = array(
      "images" => [$image_data]
    );

    $url = "https://management.api.shopserve.jp/v2/items/$item_code/images";
    $this->put($url,$image_array);

    //PC紹介文登録
    $main_description = $_POST['main_description'];
    $sub_description1 = $_POST['sub_description1'];
    $sub_description2 = $_POST['sub_description2'];
    $sales_copy = $_POST['sales_copy'];

    $description_array = array(
      "main_description"=>$main_description,
      "sub_description1"=>$sub_description1,
      "sub_description2"=>$sub_description2,
      "sales_copy"=>$sales_copy
    );
    $url = "https://management.api.shopserve.jp/v2/items/$item_code/description/pc";
    $this->put($url,$description_array);


  }


}
$Momo = new Momo;

$Momo->itemRegistration();





?>
