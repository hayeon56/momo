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
    return $data_json;
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
    $aa = $this->get($url);
    echo "<table border='1'>";
    echo "<th>商品番号</th>";
    echo "<th>価格</th>";
    echo "<th>単位</th>";
    echo "<th>メモ</th>";
    echo "<th>商品名</th>";
    echo "<tr>";
    echo "<td>".$aa['item_code']."</td>";
    echo "<td>".$aa['basic']['item_price']."</td>";
    echo "<td>".$aa['basic']['item_unit']."</td>";
    echo "<td>".$aa['basic']['memo']."</td>";
    echo "<td>".$aa['basic']['item_name']."</td>";
    echo "</tr>";
    echo "</table>";

  }

}


$Momo = new Momo;
$Momo->itemInformation();

?>
