<?php require_once('Connections/conn1.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "login.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_conn1, $conn1);
$query_product_list = "SELECT * FROM product";
$product_list = mysql_query($query_product_list, $conn1) or die(mysql_error());
$row_product_list = mysql_fetch_assoc($product_list);
$totalRows_product_list = mysql_num_rows($product_list);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta content='text/html; charset=utf-8' http-equiv='Content-Type'>
    <!-- Standard Meta -->
    <meta charset='utf-8'>
    <meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible'>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0'
      name='viewport'>
    <!-- Site Properities -->
    <title>Administration</title>


    <link rel="stylesheet" type="text/css" href="assets/dist/semantic.css">
    <link rel="stylesheet" type="text/css" href="assets/css/main.css">
    <script src="assets/js/jquery.js"></script>
    <script src="assets/dist/semantic.js"></script>
    <script src="assets/js/main.js"></script>


  </head>
  <body>
    <div class="account_chooser">
    </div>
    <div class="ui left vertical visible sidebar" id="sidebar">
      <div class="ui orange vertical labeled borderless icon menu" id="icon_tabs">
        <a class="item icon_logo"><img src="assets/images/CastarlyRock.png"></a> <!-- Compose button-->
        <!-- inbox button-->
        <a class="item" href="orders.php"><i class="inbox icon"></i>
        Orders</a> 
        <!-- contacts button-->
        <a class="active item" href="admin.php"><i class="users icon"></i>
        Products </a> 
        <!-- reports button-->
        <a class="item" href="customers.php"><i class="users icon"></i>
        Customers</a> <!-- settings button-->
        <a class="item"><i class="settings icon"></i>
        Settings</a> <!-- logout button-->
        <a class="item logout" href="<?php echo $logoutAction ?>"><i class="power icon"></i> Logout</a>
      </div>
    </div>
    
    
    <!-- ///////////////////////////////////// -->
    <div class="ui active tab right_content" data-tab="contacts">
      <!-- additional class names are added from the javascript required for the sidebar -->
      <div class="ui large borderless attached menu mobile_menu computer_hide">
        <div class="item sidebar_toggle">
          <i class="black big content icon"></i>
        </div>
        <div class="header item">Inbox</div>
      </div>
      <div class="column2">
        <div class="ui top attached large borderless menu dashboard_menu tablet_hide">
        <div class="item">Products</div>
          <div class="search item">
            <div class="ui icon small input">
              <input type="text" placeholder="Search..." class="prompt">
              <i class="search icon"></i>
            </div>
          </div>
          
          <div class="right menu">
            <a class="item toggle_column3"><i class="circular info icon"></i></a>
          </div>
        </div>
        
        <div class=" ui grid contacts_content_products">
          
          
          <div class="ui middle aligned divided list all_contacts">
            

            <ul class="item list_top">
                <li class="ui horizontal list contact_list">
                <span class="item p_image">Image</span>
                <span class="item p_name">Name</span>
                <span class="item p_quantity">Category</span>
                <span class="item p_desc">Description</span>
                <span class="item p_price">Price</span>
                <span class="item p_status">Status</span>
                <span class="item p_save">
                  
                </span>
                <span class="item p_delete">
                    
                </span>
                </li>
              </ul>


            
            <?php do { ?>
              <ul class="item">
                <li class="ui horizontal list contact_list">
                  <span class="item p_image"><img class="ui image" src="assets/<?php echo $row_product_list['ImageAddr']; ?>"></span>
                 <span class="item p_name"><?php echo $row_product_list['ProdName']; ?>
                 </span> 
                 <span class="item p_quantity">
                  <?php echo $row_product_list['category']; ?>
                  </span>
                  <span class="item p_desc"><?php echo $row_product_list['description'];?></span>
                  <span class="item p_price">shs <?php echo $row_product_list['price'];?></span>
                  <span class="item p_status">
                    <?php
                    if($row_product_list['status'] == 1){
                      echo "Active";
                    } 
                    else{
                      echo "Disabled";
                    }
                    ?>
                  </span>
                   <span class="item p_save">
                    <a class="ui tiny labeled icon orange button" href="products_edit.php?product_id=<?php echo $row_product_list['Productid']; ?>">Edit<i class="save icon"></i></a>
                    </span> 
                    <span class="item p_delete">
                      <a class="ui tiny labeled icon red button" href="products_delete.php?Productid=<?php echo $row_product_list['Productid']; ?>">Delete<i class="remove icon"></i></a>
                    </span> 
                    </li>
              </ul>
              <?php } while ($row_product_list = mysql_fetch_assoc($product_list)); ?>



            <ul class="item list_bottom">
              <a class="ui orange button" href="products_add.php">Add a product</a>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
<?php
mysql_free_result($product_list);
?>
