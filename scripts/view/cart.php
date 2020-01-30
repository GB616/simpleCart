<?php
include 'head.html';
?>
<div class="panel">
	<a href="index.php"> Back to products</a>
</div>
<div class="container">

<table>
	<thead>
		<tr style="width: 100%;"><th id="thName">Name</th><th id="thName">Price</th></tr>
	</thead>
</table>

<div class="divTable">
	<table>	
		<tbody>
			<?php foreach($_SESSION['cart'] as $product):?>
				<tr>
					<td id="thName"><?php echo $product['name']; ?></td>
					<td id="thName"><?php echo $product['price'];?></td>	
				</tr>		
			<?php endforeach; ?>
			<tr><td colspan = 2 >Total: <?php echo $price;?> </td></tr>	
		</tbody>
	</table>
</div>


<form method="post" action = "">
	<input type = "hidden" name = "operation" value = "clearCart"></input>
	<input type = "submit" value = "Clear cart" < class="button"></input>
</form>

<form method="post" action = "">
	<input type = "hidden" name = "operation" value = "bought"></input>
	<input type = "submit" value = "Buy" class="button"> </input>
</form>
</div>
<?php
include 'footer.html';
?>
