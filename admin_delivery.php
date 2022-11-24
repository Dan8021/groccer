<?php

@include 'config.php';

session_start();
class DeliveryAgent{
   public function BanDeliveryAgent($conn){

$admin_id = $_SESSION['aid'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_users = $conn->prepare("DELETE FROM `users` WHERE id = ?");
   $delete_users->execute([$delete_id]);
   header('location:admin_users.php');

}
   }}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>users</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body style = "background-image:none">
   
<?php include 'admin_header.php'; ?>

<section class="user-accounts">

   <h1 class="title">delivery_agent accounts</h1>

   <div class="box-container">

      <?php
         $select_users = $conn->prepare("SELECT users.id, users.email, delivery_agent.address, delivery_agent.image, delivery_agent.name, delivery_agent.phno, delivery_agent.pincode FROM users INNER JOIN delivery_agent on users.id=delivery_agent.did;");
         $select_users->execute();
         
         while($fetch_users = $select_users->fetch(PDO::FETCH_ASSOC)){
      ?>
      <div class="box" style="<?php if($fetch_users['id'] == $admin_id){ echo 'display:none'; }; ?>">
         <img src="uploaded_img/<?= $fetch_users['image']; ?>" alt="">
         <p> user id : <span><?= $fetch_users['id']; ?></span></p>
         <p> username : <span><?= $fetch_users['name']; ?></span></p>
         <p> email : <span><?= $fetch_users['email']; ?></span></p>
         
         <a href="admin_delivery.php?delete=<?= $fetch_users['id']; ?>" onclick="return confirm('delete this delivery agent?');" class="delete-btn">delete</a>
      </div>
      <?php
      }
      ?>
   </div>

</section>
<?php 
$new = new DeliveryAgent();
$new-> BanDeliveryAgent($conn);

include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>