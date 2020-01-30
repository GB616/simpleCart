<?php 
include  'scripts/include/panel.php';

include 'head.html';
?>

<div class="container">
	<form method = "get" action="">
		<select name="category">
			<option value="0">Category</option>
			<?php foreach($categories as $category) : ?>
				<option <?php if(isset($_GET['category']) && $_GET['category'] == $category['id']) echo "selected"; ?>  value = "<?php echo $category['id']?>"><?php echo $category['name'] ?></option>
			<?php endforeach; ?>
		</select>
		<input type="submit" value="select"></input>
	</form>
	
	<table>
		<thead>
			<tr><th>Name</th><th>Description</th><th>In stock</th><th>Price</th><th>Buy</th></tr>
		</thead>
	</table>

	<div class="divTable">
		<table>
			<tbody>
				<?php foreach($products as $product):?>
				<tr>
					<td><?php echo $product['name']; ?></td>
					<td><?php echo $product['description']; ?></td>
					<td><?php echo $product['stock'];?></td>
					<td><?php echo $product['price'];?></td>
					<td>
						<form method="post" action = "">
							<input type = "hidden"	name = "id" value = <?php echo $product['id'];	?>></input>
							<input type = "hidden"	name = "stock" value = <?php echo $product['stock'];	?>></input>
							<input type = "hidden"	name = "name" value = <?php echo $product['name'];	?>></input>
							<input type = "hidden"	name = "price" value = <?php echo $product['price'];	?>></input>
							<input type = "hidden"  name = "operation" value = "buyProduct"></input>
							<input type = "submit"  value = " Buy" class="button"> </input>
						</form>
					</td>
				</tr>		
				<?php endforeach; ?>			
			</tbody>	 
		</table>
	</div>
	<?php 
	if(isset($pages))
	{
		echo "<div style=\"float: left; \">Page  </div>";
		
		for($i = 1; $i<=$pages+1; $i++)
		{
			echo "<form method=\"GET\" action = \"\" style=\"float: left\">
			<input type = \"hidden\" name = \"page\" value = \"{$i}\"></input>
			<input type = \"submit\" value = \"{$i}\" > </input>
			</form>";
		}
   }
	?>
</div>
<?php
include 'footer.html';
?>