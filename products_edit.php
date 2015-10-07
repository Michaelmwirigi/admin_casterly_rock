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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE product SET ProdName=%s, ImageAddr=%s, price=%s, `description`=%s, category=%s, status=%s WHERE Productid=%s",
                       GetSQLValueString($_POST['ProdName'], "text"),
                       GetSQLValueString($_POST['ImageAddr'], "text"),
                       GetSQLValueString($_POST['price'], "text"),
                       GetSQLValueString($_POST['description'], "text"),
                       GetSQLValueString($_POST['category'], "text"),
                       GetSQLValueString($_POST['status'], "int"),
                       GetSQLValueString($_POST['Productid'], "int"));

  mysql_select_db($database_conn1, $conn1);
  $Result1 = mysql_query($updateSQL, $conn1) or die(mysql_error());

  $updateGoTo = "admin.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_edit_product = "-1";
if (isset($_GET['Productid'])) {
  $colname_edit_product = $_GET['Productid'];
}
mysql_select_db($database_conn1, $conn1);
$query_edit_product = sprintf("SELECT * FROM product WHERE Productid = %s", GetSQLValueString($colname_edit_product, "int"));
$edit_product = mysql_query($query_edit_product, $conn1) or die(mysql_error());
$row_edit_product = mysql_fetch_assoc($edit_product);
$colname_edit_product = "-1";
if (isset($_GET['product_id'])) {
  $colname_edit_product = $_GET['product_id'];
}
mysql_select_db($database_conn1, $conn1);
$query_edit_product = sprintf("SELECT * FROM product WHERE Productid = %s", GetSQLValueString($colname_edit_product, "int"));
$edit_product = mysql_query($query_edit_product, $conn1) or die(mysql_error());
$row_edit_product = mysql_fetch_assoc($edit_product);
$totalRows_edit_product = mysql_num_rows($edit_product);
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
    <title>Edit Product</title>


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
          <h4 class="ui header">Edit Product</h4>
        </div>
        <div class="ui segment">
          <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
            <table align="center">
              <tr valign="baseline">
                <td nowrap align="right">ProdName:</td>
                <td><input type="text" name="ProdName" value="<?php echo htmlentities($row_edit_product['ProdName'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
              </tr>
              <tr valign="baseline">
                <td nowrap align="right">ImageAddr:</td>
                <td><input type="text" name="ImageAddr" value="<?php echo htmlentities($row_edit_product['ImageAddr'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
              </tr>
              <tr valign="baseline">
                <td nowrap align="right">Price:</td>
                <td><input type="text" name="price" value="<?php echo htmlentities($row_edit_product['price'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
              </tr>
              <tr valign="baseline">
                <td nowrap align="right" valign="top">Description:</td>
                <td><textarea name="description" cols="50" rows="5"><?php echo htmlentities($row_edit_product['description'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
              </tr>
              <tr valign="baseline">
                <td nowrap align="right">Category:</td>
                <td><input type="text" name="category" value="<?php echo htmlentities($row_edit_product['category'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
              </tr>
              <tr valign="baseline">
                <td nowrap align="right">Status:</td>
                <td><select name="status">
                  <option value="1" <?php if (!(strcmp(1, htmlentities($row_edit_product['status'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Active</option>
                  <option value="2" <?php if (!(strcmp(2, htmlentities($row_edit_product['status'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Diactivate</option>
                </select></td>
              </tr>
              <tr valign="baseline">
                <td nowrap align="right">&nbsp;</td>
                <td><input type="submit" value="Update record"></td>
              </tr>
            </table>
            <input type="hidden" name="MM_update" value="form1">
            <input type="hidden" name="Productid" value="<?php echo $row_edit_product['Productid']; ?>">
          </form>
          <p>&nbsp;</p>
<p>&nbsp;</p>
        </div>
        
      </div>
    </div>
  </body>
</html>
<?php
mysql_free_result($edit_product);
?>
