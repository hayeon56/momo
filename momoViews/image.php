<?php
include("../momoControllers/momoImageController.php");

$image = $Momo->image();

$temp = $_GET['image'];
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <script type="text/javascript" src="http://code.jquery.com/jquery.js"></script>
    <title></title>
  </head>
  <body>
    <script>
      function insert(temp,image){

          if(temp == 'main_image'){
            if($("#main_image",opener.document).val()){
              $("#main_image_1",opener.document).remove();
              $("#main_image",opener.document).remove();
              var imagesrc = "<img src='http://eat584.ev.shopserve.jp/pic-labo/"+image+"'width='100px' id='main_image_1' value='"+image+"'>";
              var image_name_hidden = "<input id='main_image' type='hidden' name='image_name' value='"+image+"'>";
              var image_is_mail = "<input type='hidden' name='is_main' value='Yes'>";
              $("#hayeon",opener.document).append(imagesrc);
              $("#sou",opener.document).append(image_name_hidden,image_is_mail);
              alert("登録完了。");
              close();
            }
            else{
            var imagesrc = "<img src='http://eat584.ev.shopserve.jp/pic-labo/"+image+" width='100px' height='100px'  id='main_image_1' value='"+image+"'>";
            var image_name_hidden = "<input id='main_image' type='hidden' name='image_name' value='"+image+"'>";
            var image_is_mail = "<input type='hidden' name='is_main' value='Yes'>";
            $("#hayeon",opener.document).append(imagesrc);
            $("#sou",opener.document).append(image_name_hidden,image_is_mail);
            $("#cell_1",opener.document).append(imagesrc);
            alert("登録完了。");
            close();

              }
            }


        else if(temp == 'main_description'){
          var imagesrc = "<img src='http://eat584.ev.shopserve.jp/pic-labo/"+image+"'>";
          var haha = $("#main_description",opener.document).val();
          haha+="<img src='http://eat584.ev.shopserve.jp/pic-labo/"+image+"'>";
          $("#main_description",opener.document).val(haha);
          alert("挿入完了。");
        }

        else if(temp == 'sub_description1'){
          var imagesrc = "<img src='http://eat584.ev.shopserve.jp/pic-labo/"+image+">";
          var haha = $("#sub_description1",opener.document).val();
          haha+="<img src='http://eat584.ev.shopserve.jp/pic-labo/"+image+"'>";
          $("#sub_description1",opener.document).val(haha);
          alert("挿入完了。");
        }

        else if(temp == 'sub_description2'){
          var imagesrc = "<img src='http://eat584.ev.shopserve.jp/pic-labo/"+image+">";
          var haha = $("#sub_description2",opener.document).val();
          haha+="<img src='http://eat584.ev.shopserve.jp/pic-labo/"+image+"'>";
          $("#sub_description2",opener.document).val(haha);
          alert("挿入完了。");
        }
      }

    </script>
    <table border="1">
      <th>画像</th>
      <th>ファイル名/挿入する</th>
      <th>代替テキスト/画像カテゴリ</th>
      <tr>
        <?php for($i = 0; $i < sizeof($image); $i++){ ?>
        <tr>
        <td><img src="http://eat584.ev.shopserve.jp/pic-labo/<?=$image[$i]['image_name']?>" width='100px'></td>
        <td><?=$image[$i]['image_name']?><br><?=$image[$i]['registered_at']?><br><button type="submit" onclick="insert('<?php echo $temp ?>','<?=$image[$i]['image_name']?>')">挿入する</button></td>
        <td><?=$image[$i]['image_category_name']?><br><?=$image[$i]['alt']?></td>
        <?php } ?>
      </tr>
    </table>
  </body>
</html>
