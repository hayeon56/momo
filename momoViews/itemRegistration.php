<?php
  include("../momoControllers/momoCategoryController.php");
  $category = $Momo->category();
  $image = $Momo->image();
?>
<script type="text/javascript" src="http://code.jquery.com/jquery.js"></script>
<script type="text/javascript">

    function test(){

      if(momoform.item_code.value == ""){
        alert("商品番号を入力してください。");
        momoform.item_code.focus();
        return false;
      }
      else if(momoform.item_name.value == ""){
        alert("商品名を入力してください。");
        momoform.item_name.focus();
        return false;
      }
      else if(momoform.item_price.value == ""){
        alert("販売価格を入力してください。");
        momoform.item_price.focus();
        return false;
      }
      else if(momoform.item_unit.value == ""){
        alert("単位を入力してください。");
        momoform.item_unit.focus();
        return false;
      }
      else if(momoform.item_category.value == ""){
        alert("カテゴリを選択してください。");
        momoform.item_category.focus();
        return false;
      }
      else if(isNaN(momoform.item_price.value)){
        alert("数字だけ入力可能、半角カンマ（,）半角ピリオド（.）不要");
        momoform.item_price.focus();
        return false;
      }
      else if(momoform.bundle_packing.value == ""){
        alert("同梱不可設定をしてください。");
        momoform.bundle_packing.focus();
        return false;
      }
    }
      $(document).ready(function(){

       $("input[name='delivery_type']:checkbox").change(function(){

          if(document.getElementById("delivery_type").checked == true){
            $('#temperature_controlled1').prop('disabled', true);
            $('#temperature_controlled2').prop('disabled', true);
            $('#enable_specific_shipping_charge').prop('disabled', true);
            $('#specific_shipping_charge').prop('disabled', true);
            $('#prior').prop('disabled', true);
            $('#display_type').prop('disabled', true);
          }
          else{
             $('#temperature_controlled1').prop('disabled', false);
             $('#temperature_controlled2').prop('disabled', false);
             $('#enable_specific_shipping_charge').prop('disabled', false);
             $('#specific_shipping_charge').prop('disabled', false);
             $('#prior').prop('disabled', false);
             $('#display_type').prop('disabled', false);
          }
     });
      $("input[name='enable_specific_shipping_charge']:checkbox").change(function(){

        if(document.getElementById("enable_specific_shipping_charge").checked == true){
          $('#delivery_type').prop('disabled', true);
          $('#display_type').prop('disabled', false);
          $('#prior').prop('disabled', false);
        }
        else{
            $('#delivery_type').prop('disabled', false);
            $('#display_type').prop('disabled', true);
            $('#prior').prop('disabled', true);
        }
    });
    $("input[name='temperature_controlled1']:checkbox").change(function(){

      if(document.getElementById("temperature_controlled1").checked == true){
        $('#temperature_controlled2').prop('disabled', true);
        $('#delivery_type').prop('disabled', true);
      }
      else{
          $('#temperature_controlled2').prop('disabled', false);
          $('#delivery_type').prop('disabled', false);
      }
  });
  $("input[name='temperature_controlled2']:checkbox").change(function(){

    if(document.getElementById("temperature_controlled2").checked == true){
      $('#temperature_controlled1').prop('disabled', true);
      $('#delivery_type').prop('disabled', true);
    }
    else{
        $('#temperature_controlled1').prop('disabled', false);
        $('#delivery_type').prop('disabled', false);
    }
});



});

function popup(param){
  var url="image.php?image="+param;
  var option="width=700, height=700, top=200";

  window.open(url, "", option);
}

function image_delete(){
  $("#main_image_1").remove();
  $("#main_image").remove();
}

</script>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <style type="text/css">
      .my-box { border:1px solid; padding:10px; width: 1000px;}
      .my-box2 { border:1px dashed; padding:10px; width: 800px;}
      table{
        width: 500px;
        height: 100px;
      }
    </style>
  </head>
  <body>
    <center>
    <h1>商品登録</h1>
    <div class="my-box">
    <h2>基本情報</h2>
    <form name="momoform" action="../momoControllers/momoController.php/itemRegistration" onsubmit="test()" method="post" id="sou">
    <strong>商品番号</strong><br><br><input type="text" name="item_code" placeholder="商品番号" >
    <p>※半角英数字「-（ハイフン）」、「_（アンダーバー）」64文字以内</p>
    <hr>
    <strong>商品名</strong><br><br><input type="text" name="item_name" placeholder="商品名" >
    <p>※全角127文字以内</p>
    <hr>
    <strong>消費税設定</strong><br><br>
    <input type="radio" name="consumption_tax_setting" id="consumption_tax_setting" value="Standard"  />標準
    <input type="radio" name="consumption_tax_setting" id="consumption_tax_setting" value="TaxExempt"  />非課税
    <label for="Standard">※　価格欄には「税込価格」を入力</label>
    <label for="TaxExempt">※　価格欄には「非課税価格」を入力</label>
    <hr>
    <strong>販売価格</strong><br><br>
    <input type="text" name="item_price" placeholder="商品価格（税込）" >
    <p>※半角8文字以内／半角カンマ（,）半角ピリオド（.）不要</p>
    <p>※定期購入・頒布会用として登録する場合は350円以上</p>
    <p>※バリエーションごとに価格を設定する場合は最低価格を入力</p>
    <hr>
    <strong>単位</strong><br><br><input type="text" name="item_unit" placeholder="商品単位" >
    <br><p>例：「個」「枚」「本」「セット」など</p>
    <hr>
    <strong>メモ</strong><br><br><textarea rows="4" cols="40" name="memo" placeholder="メモ" ></textarea>
    <hr>
    <strong>カテゴリ</strong><br><br>
    <select multiple="multiple" name="item_category">
      <?php for($i = 0; $i < sizeof($category); $i++){ ?>
        <option value="<?=$category[$i]?>"><?php echo $category[$i] ?></option>
      <?php } ?>
    </select>
    </div>
    <br>
    <div class="my-box">
      <h2>販売情報</h2>
      <strong>同梱不可設定</strong>
      <br><br>
      <input type="radio" name="bundle_packing" value="Allow"/>利用しない
      <input type="radio" name="bundle_packing" value="Deny"/>利用する
      <hr>
      <strong>送料</strong>
      <br>
      <br>
      <div class="my-box2">
        <input type="checkbox" name="delivery_type" id="delivery_type" value="Mail"/>メール便
      </div>
      <br>
      <div class="my-box2">
      <input type="checkbox" name="enable_specific_shipping_charge" id="enable_specific_shipping_charge" value="Yes"/>個別に送料を設定する
      <input type="text" name="specific_shipping_charge">円
      <br>
      <input type="checkbox" name="display_type" id="display_type" value="Zero" disabled="disabled"/>0円の場合はカートに「送料無料」と表示する
      <br>
      <input type="checkbox" name="prior" id="prior" value="Yes" disabled="disabled"/>この送料を優先する
      </div>
      <br>
      <div class="my-box2">
        <input type="checkbox" name="temperature_controlled1" id="temperature_controlled1" value="Cold"/>冷蔵便
        <br>
        <input type="checkbox" name="temperature_controlled2" id="temperature_controlled2" value="Freeze"/>冷凍便
      </div>
    </div>
    <br><br>
    <div class="my-box">
      <h2>商品ページ情報</h2>
      <strong>メイン画像(1つまで)</strong>
      <br><br>
      <a href="javascript:popup('main_image')" target="_blank"><button type="button" name="image_modal_open_btn">画像挿入</button></a>
      <button type="button" name="image_delete_btn" onclick="image_delete()">削除</button>
      <div id="hayeon">
      </div>
      <br>
      <hr>
      <br>
      <strong>サブ画像(9つまで)</strong>
      <table border="1" id="test" width=100px>
        <tr>
          <td id="cell_1"></td>
          <td id="cell_2"></td>
          <td id="cell_3"></td>
          <td id="cell_4"></td>
          <td id="cell_5"></td>
        </tr>
        <tr>
          <td id="cell_6">dd</td>
          <td id="cell_7">dd</td>
          <td id="cell_8">dd</td>
          <td id="cell_9">dd</td>
          <td id="cell_10">dd</td>
        </tr>
      </table>
      <br><br><hr>
      <strong>商品紹介文</strong>
      <p>メイン紹介文</p>
      <a href="javascript:popup('main_description')" target="_blank"><button type="button" name="image_modal_open_btn">画像挿入</button></a><br>
      <textarea id="main_description" rows="10" cols="50" name="main_description" placeholder="" ></textarea>
      <p>サブ紹介文１</p>
      <a href="javascript:popup('sub_description1')" target="_blank"><button type="button" name="image_modal_open_btn">画像挿入</button></a><br>
      <textarea id="sub_description1" rows="10" cols="50" name="sub_description1" placeholder="" ></textarea>
      <p>サブ紹介文２</p>
      <a href="javascript:popup('sub_description2')" target="_blank"><button type="button" name="image_modal_open_btn">画像挿入</button></a><br>
      <textarea id="sub_description2" rows="10" cols="50" name="sub_description2" placeholsder="" ></textarea>
      <p>内部用キャッチコピー</p>
      <textarea rows="10" cols="50" name="sales_copy" placeholder="" ></textarea>
    </div>
    <div>
    <br><br>
    <button type="submit">Submit</button>
    <br><br><br><br><br><br>
    </div>
    </form>
  </center>
  </body>
</html>
