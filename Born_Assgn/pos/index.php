</html>
	<head>
		<title>POS SCAN API</title>
	</head>
	<body>
		<div class="pos-checkout">
			<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="pos-cart">
				<label>Add Products:</label>
				<input type="text"  value="<?php echo (isset($_POST["product"]) && $_POST["product"]) ? strtoupper($_POST["product"]) : '' ?>" name="product" />
				<button type="submit" name="submit" id="cart-process">Add To Cart</button>
			</form>
			<?php 
			include 'Terminal.php';
			
			$terminal = new Terminal();
			$terminal->addProductDetail('A', 2.00, array('4' => 7.00));
			$terminal->addProductDetail('B', 12.00);
			$terminal->addProductDetail('C', 1.25, array('6' => 6.00));
			$terminal->addProductDetail('D', 0.15);
				
			if (isset($_POST["submit"])) {
				$products = (isset($_POST["product"]) && $_POST["product"] ) ? strtoupper($_POST["product"]) : '';
				/**
				 * Check if Any Special Character is found in products.
				 */
				if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $products)) {
					echo "One or more of the 'special characters' found ";
				} else {
					$terminal->scan($products);
				}
			}

				$terminal->setProductPrice('A', 2.00, array('4' => 7.00));
			?>
		</div>
	</body>
</html>

