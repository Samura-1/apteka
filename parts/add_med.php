<?php
ob_start();
require_once '../bd/bd.php';
?>
<?php 
if (isset($_SESSION['login'])) :?>
<?php 
require_once '../parts/head.php';
require_once '../parts/header.php';
?>
<?php
$farm = $connection->prepare("SELECT `name_grop` FROM `type`");
$farm ->execute();
$farm = $farm->FETCHALL(PDO::FETCH_ASSOC);
$provider = $connection->prepare("SELECT `name` FROM `provider`");
$provider->execute();
$provider = $provider->FETCHALL(PDO::FETCH_ASSOC);
//add_med
$data = $_POST;
if (isset($data['do_add'])) {
$uploaddir='../img/upload/';
$uploadfile1 = $uploaddir.basename($_FILES['img']['name']);
move_uploaded_file($_FILES['img']['tmp_name'], $uploadfile1);

$add_medic = $connection->prepare("INSERT INTO `medicines`(`name`, `id_gr`, `count`, `price`, `photo`, `description`,`provider`) VALUES (:name,:id_gr,:count_pre,:price,:photo,:descripti,:provider)");
$add_medic->bindParam(':name',htmlspecialchars($data['name_prep']));
$add_medic->bindParam(':id_gr',htmlspecialchars($data['farm']));
$add_medic->bindParam(':count_pre',htmlspecialchars($data['count']));
$add_medic->bindParam(':price',htmlspecialchars($data['price']));
$add_medic->bindParam(':provider',htmlspecialchars($data['provider']));
$add_medic->bindParam(':photo',$uploadfile1);
$add_medic->bindParam(':descripti',htmlspecialchars($data['description']));
$add_medic->execute();
header('Location: ../parts/add_page.php');
}
?>
  <body id="bg">
      <div class="container">
        <div class="row">
        <div class="menu-center" style="height: 750px!important; padding: 10px 40px!important;">
          <div class="contaner">
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <p class="text-center">Добавить препарат</p>
              </div>
              <div class="col-lg-12 col-md-12">
                 <form enctype="multipart/form-data" action="add_med.php" method="POST">
                  <div class="form-group">
                    <label for="exampleInput">Название</label>
                    <input type="text" class="form-control" id="exampleInput" name="name_prep" placeholder="Название препарата" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleFormControlFile1">Фото</label>
                    <input type="file" class="form-control-file" name="img" id="exampleFormControlFile1" required accept="image/*,image/jpeg">
                  </div>
                  <div class="form-group">
                    <label for="exampleFormControlSelect1">Фарм. группа</label>
                    <select class="form-control" id="exampleFormControlSelect1" name="farm" required>
                      <?php foreach ($farm as $farm): ?>
                        <option><?= $farm['name_grop'];?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleFormControlSelect1">Поставщик</label>
                    <select class="form-control" id="exampleFormControlSelect1" name="provider" required>
                      <?php foreach ($provider as $provider): ?>
                        <option><?= $provider['name'];?></option>
                      <?php endforeach ?>
                    </select>
                  </div>                                      
                  <div class="form-group">
                    <label for="exampleInput1">Цена</label>
                    <input type="number" class="form-control" id="exampleInput1" name="price" placeholder="Цена" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInput1">Количество</label>
                    <input type="number" class="form-control" id="exampleInput1" name="count" placeholder="Количество" required>
                  </div>                  
                  <div class="form-group">
                    <label for="exampleFormControlTextarea1">Описание</label>
                    <textarea style="resize: none;" class="form-control" name="description" id="exampleFormControlTextarea1" rows="3"></textarea>
                  </div>                  
                  <button type="submit" class="btn btn-primary" name="do_add">Добавить <img src="../img/add.png" alt=""></button>
                 </form>                
              </div>                          
            </div>
          </div>
        </div>            
        </div>
      </div>
<?php require_once '../parts/footer.php';?>
<?php else :?>
<?php
header('Location: ../index.php');
ob_end_flush();
?>
<?php endif;?>