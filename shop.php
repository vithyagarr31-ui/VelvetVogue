<?php
session_start(); 

$conn = new mysqli("localhost", "root", "", "velvetvogue");

$sql = "SELECT * FROM products WHERE 1=1";

// Apply filters
if (!empty($_GET['category'])) {
    $category = $_GET['category'];
    $sql .= " AND category = '$category'";
}

if (!empty($_GET['size'])) {
    $size = $_GET['size'];
    $sql .= " AND size = '$size'";
}

if (!empty($_GET['gender'])) {
    $gender = $_GET['gender'];
    $sql .= " AND gender = '$gender'";
}

$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Velvet Vogue - Shop</title>
  <link rel="stylesheet" href="shop.css" />
  
</head>
<body>

<header>
  <h1>🛍 Velvet Vogue - Products</h1>
  <a href="cart.php">🛒 View Cart</a>
  <a href="product.html">See Product Details</a>
  <nav class="navbar">
    <ul class="nav-links">
      <li><a href="index.html">Home</a></li>
      <li><a href="Login.html">Login</a></li>
      <li><a href="shop.php" class="active">Shop</a></li>
      <li><a href="contact.html">Contact</a></li>
      <li><a href="aboutus.html">About Us</a></li>
    </ul>
    <div style="clear: both;"></div>
  </nav>
</header>

<form method="GET" class="filter-form">
  <label>Category:
    <select name="category">
      <option value="">All</option>
      <option value="Winter">Winter</option>
      <option value="Summer">Summer</option>
      <option value="Formal">Formal</option>
      <option value="Causal">Causal</option>
	   <option value="Accessories">Accessories</option>
    </select>
  </label>

  <label>Size:
    <select name="size">
      <option value="">All</option>
      <option value="S">S</option>
      <option value="M">M</option>
      <option value="L">L</option>
    </select>
  </label>

  <label>Gender:
    <select name="gender">
      <option value="">All</option>
      <option value="Men">Men</option>
      <option value="Women">Women</option>
      <option value="Unisex">Unisex</option>
    </select>
  </label>

  <button type="submit">Apply Filter</button>
</form>

<div class="product-grid">
  <?php while ($row = $result->fetch_assoc()): ?>
    <div class="product-card">
      <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
      <h3><?php echo $row['name']; ?></h3>
      <p>Price: $<?php echo $row['price']; ?></p>
      <p>Category: <?php echo $row['category']; ?></p>
      <p>Size: <?php echo $row['size']; ?> | Gender: <?php echo $row['gender']; ?></p>
      <form method="POST" action="add_to_cart.php">
        <input type="hidden" name="product_id" value="<?php echo $row['Id']; ?>">
        <input type="hidden" name="name" value="<?php echo $row['name']; ?>">
        <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
        <input type="hidden" name="qty" value="1">
        <button type="submit">Add to Cart</button>
      </form>
    </div>
  <?php endwhile; ?>
</div>

</body>
</html>
