<?php require_once('Connections/conn1.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO product (ProdName, price, `description`, category, status) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['ProdName'], "text"),
                       GetSQLValueString($_POST['price'], "text"),
                       GetSQLValueString($_POST['description'], "text"),
                       GetSQLValueString($_POST['category'], "text"),
                       GetSQLValueString($_POST['status'], "int"));

  mysql_select_db($database_conn1, $conn1);
  $Result1 = mysql_query($insertSQL, $conn1) or die(mysql_error());

  $insertGoTo = "admin.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_conn1, $conn1);
$query_add_product = "SELECT * FROM product";
$add_product = mysql_query($query_add_product, $conn1) or die(mysql_error());
$row_add_product = mysql_fetch_assoc($add_product);
$totalRows_add_product = mysql_num_rows($add_product);
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
    <title>Add Product</title>


    <link rel="stylesheet" type="text/css" href="assets/dist/semantic.css">
    <link rel="stylesheet" type="text/css" href="assets/css/main.css">
    <script src="assets/js/jquery.js"></script>
    <script src="assets/dist/semantic.js"></script>
    <script src="assets/js/main.js"></script>


  </head>
  <body class="ui centered grid container">
    <div class="ui centered grid">
      <div class="ui raised segments">
        <div class="ui segment">
          <h4 class="ui header">New Product</h4>
        </div>
        <div class="ui segment">
          <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
            <table align="center">
              <tr valign="baseline">
                <td nowrap align="right">ProdName:</td>
                <td><input type="text" name="ProdName" value="" size="32"></td>
              </tr>
              <tr valign="baseline">
                <td nowrap align="right">Price:</td>
                <td><input type="text" name="price" value="" size="32"></td>
              </tr>
              <tr valign="baseline">
                <td nowrap align="right">Description:</td>
                <td><input type="text" name="description" value="" size="32"></td>
              </tr>
              <tr valign="baseline">
                <td nowrap align="right">Category:</td>
                <td><input type="text" name="category" value="" size="32"></td>
              </tr>
              <tr valign="baseline">
                <td nowrap align="right">Status:</td>
                <td><select name="status">
                  <option value="1" <?php if (!(strcmp(1, ""))) {echo "SELECTED";} ?>>Active</option>
                  <option value="2" <?php if (!(strcmp(2, ""))) {echo "SELECTED";} ?>>Diactivate</option>
                </select></td>
              </tr>
              <tr valign="baseline">
                <td nowrap align="right">&nbsp;</td>
                <td><input type="submit" value="Add Product"></td>
              </tr>
            </table>
            <input type="hidden" name="MM_insert" value="form1">
          </form>
          <p>&nbsp;</p>
        </div>
        
      </div>
    </div>
  </body>
</html>
<?php
mysql_free_result($add_product);
?>
