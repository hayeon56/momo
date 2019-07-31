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
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);     // 원격서버의 인증서가 유효한지 검사 안함
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

  }


  //カテゴリプリント
  public function category(){
    $url = "https://management.api.shopserve.jp/v2/service-setup/item-categories/_get";
    $category_data = $this->post($url);
    $num = 0;
    $category_arr = array();

    //for始まり
     for($i = 0; $i < sizeof($category_data['child_categories']); $i++){
       $category_1 = $category_data['child_categories'][$i]['full_path'][0];//상위 폴더 이름 뽑아오기
        $category_arr[$num] = $category_1;
         $num++;
         if($category_data['child_categories'][$i]['has_child_categories'] == 'Yes'){
           $data = "{\"top_category_path\":[\"".$category_1."\"]}";
           $category_data2 = $this->post($url,$data);
           for($j = 0; $j < sizeof($category_data2['child_categories']); $j++){
            $category_2 = $category_data2['child_categories'][$j]['full_path'][1];
              $category_arr[$num] = $category_1.">".$category_2;
                $num++;
             if($category_data2['child_categories'][$j]['has_child_categories'] == 'Yes'){
               $data = "{\"top_category_path\":[\"".$category_1."\",\"".$category_2."\"]}";
               $category_data3 = $this->post($url,$data);

              for($z = 0; $z < sizeof($category_data3['child_categories']); $z++){
                 $category_3 = $category_data3['child_categories'][$z]['full_path'][2];
                  $category_arr[$num] = $category_1.">".$category_2.">".$category_3;
                   $num++;
                  if($category_data3['child_categories'][$j]['has_child_categories'] == 'Yes')
                  $data = "{\"top_category_path\":[\"".$category_1."\",\"".$category_2."\",\"".$category_3."\"]}";
                  $category_data4 = $this->post($url,$data);

                   for($e = 0; $e < sizeof($category_data4['child_categories']); $e++){
                     $category_4 = $category_data4['child_categories'][$e]['full_path'][3];
                      $category_arr[$num] = $category_1.">".$category_2.">".$category_3.">".$category_4;
                        $num++;
                      if($category_data4['child_categories'][$e]['has_child_categories'] == 'Yes'){
                        $data = "{\"top_category_path\":[\"".$category_1."\",\"".$category_2."\",\"".$category_3."\",\"".$category_4."\"]}";
                        $category_data5 = $this->post($url,$data);

                        for($r = 0; $r < sizeof($category_data5['child_categories']); $r++){
                          $category_5 = $category_data5['child_categories'][$r]['full_path'][4];
                          $data = "{\"top_category_path\":[\"".$category_1."\",\"".$category_2."\",\"".$category_3."\",\"".$category_4."\"]}";
                          $category_arr[$num] = $category_1.">".$category_2.">".$category_3.">".$category_4.">".$category_5;
                            $num++;
                        }
                      }
                   }
                }
             }
           }
        }
     }
   //for終わり
   return $category_arr;
  }

  //画像呼び出し
  public function image(){

    $url = "https://management.api.shopserve.jp/v2/images";
    $image_data = $this->get($url);
    for($i = 0; $i < sizeof($image_data['images']); $i++){
      $image_arr[$i]['image_name'] = $image_data['images'][$i]['image_name'];
      $image_arr[$i]['alt'] = $image_data['images'][$i]['alt'];
      $image_arr[$i]['image_category_name'] = $image_data['images'][$i]['image_category_name'];
      $image_arr[$i]['registered_at'] = $image_data['images'][$i]['registered_at'];
    }

    return $image_arr;

  }


}
$Momo = new Momo;





?>
