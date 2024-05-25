<?php
session_start();
require 'connection.php';

if (!isset($_SESSION['email'])) {
    header('location: login.php');
}

$user_id = $_SESSION['id'];
$user_products_query = "SELECT it.id, it.name, it.price, ut.quantity 
                        FROM users_items ut 
                        INNER JOIN items it ON it.id = ut.item_id 
                        WHERE ut.user_id='$user_id'";
$user_products_result = mysqli_query($con, $user_products_query) or die(mysqli_error($con));
$no_of_user_products = mysqli_num_rows($user_products_result);
$sum = 0;

if ($no_of_user_products == 0) {
    ?>
    <script>
        window.alert("No items in the cart!!");
    </script>
<?php
} else {
    while ($row = mysqli_fetch_array($user_products_result)) {
        $sum += $row['price'] * $row['quantity'];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
   
    <title>SoyToyWorld Store</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- latest compiled and minified CSS -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css">
    <!-- jquery library -->
    <script type="text/javascript" src="bootstrap/js/jquery-3.2.1.min.js"></script>
    <!-- Latest compiled and minified javascript -->
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <!-- External CSS -->
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body>
<div>
    <?php require 'header.php'; ?>
    <br>
    <div class="container">
        <table class="table table-bordered table-striped">
            <tbody>
            <tr>
                <th>Item Number</th>
                <th>Item Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th></th>
            </tr>
            <?php
            $user_products_result = mysqli_query($con, $user_products_query) or die(mysqli_error($con));
            $counter = 1;
            while ($row = mysqli_fetch_array($user_products_result)) {
                ?>
                <tr>
                    <td><?php echo $counter; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['price']; ?></td>
                    <td>
                        <form action="update_quantity.php" method="POST">
                            <input type="hidden" name="item_id" value="<?php echo $row['id']; ?>">
                            <input type="number" name="quantity" value="<?php echo $row['quantity']; ?>" min="1">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </td>
                    <td><?php echo $row['price'] * $row['quantity']; ?></td>
                    <td><a href='cart_remove.php?id=<?php echo $row['id']; ?>'>Remove</a></td>
                </tr>
                <?php
                $counter++;
            }
            ?>
            <tr>
                <td></td>
                <td>Total</td>
                <td></td>
                <td></td>
                <td>Rs <?php echo $sum; ?>/-</td>
                <td><a href="success.php?id=<?php echo $user_id; ?>" class="btn btn-primary">Confirm Order</a></td>
            </tr>
            </tbody>
        </table>
    </div>
    <br><br><br><br><br><br><br><br><br><br>
    <footer class="footer">
    <div class="container">
        <div class="text-center">
            <p>&copy; 2024 SoyToy World. All Rights Reserved.</p>
            <p>This website is developed by Vaibhav, Kirtan, and Tanmay.</p>
        </div>
    </div>
</footer>
</div>
</body>
</html>
