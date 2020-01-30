<?php
session_start();
if(!isset($_SESSION['cart']))
{
	$_SESSION['cart'] = array();
}


	if(isset($_POST['operation']) && $_POST['operation'] == 'buyProduct')
	{
		try{
			$stock = $_POST['stock'] - 1;
			
			require_once 'scripts/include/database.php';
			$id = filter_input(INPUT_POST, 'id');
			
			$updateProduct =  $db->prepare("UPDATE products SET stock = :stock WHERE id = :id");
			$updateProduct->bindValue(':id', $id, PDO::PARAM_INT);
			$updateProduct->bindValue(':stock', $stock, PDO::PARAM_STR);
			$updateProduct->execute();
			
			$_SESSION['cart'][] = array( 'id' =>  $_POST['id'], 'name' => $_POST['name'],'price' => $_POST['price']);
			header('Location: .'); 
			exit();
		}
		catch(PDOException $error){
			echo "Error while buying: " . $error;
			exit();
		}
	}
	else if(isset($_POST['operation']) && $_POST['operation'] == 'clearCart')
	{
		foreach($_SESSION['cart'] as $item)
		{
			try{
				require_once 'scripts/include/database.php';
				$id = $item['id'];
			
				$updateProduct =  $db->prepare("UPDATE products SET stock = stock + 1  WHERE id = :id");
				$updateProduct->bindValue(':id', $id, PDO::PARAM_INT);
				$updateProduct->execute();
			}
			catch(PDOException $error){
				echo "Error while buying: " . $error;
				exit();
			}
		}
		unset($_SESSION['cart']);
		header('Location: ?cart');
		exit();	
		
	}
	if(isset($_POST['operation']) && $_POST['operation'] == 'signin')
	{
		try{
			require_once 'scripts/include/database.php';
			
			$login = filter_input(INPUT_POST, 'login');
			$password = filter_input(INPUT_POST, 'password');
			$passwordmd5 = md5($password);

			$loginQuery = $db->prepare('SELECT id FROM clients WHERE login = :login AND password = :password');
			$loginQuery->bindValue(':login',$login,PDO::PARAM_STR);
			$loginQuery->bindValue(':password',$passwordmd5,PDO::PARAM_STR);
			$loginQuery->execute();
		    
			$correct = $loginQuery->rowCount();
			
			if($correct>0)
			{	
		        $idl =  $loginQuery->fetch();
				$_SESSION['logged_id'] = $idl['id'];
				$_SESSION['logged_login'] = $login;	
				header('Location: .');
				exit();
			}
			else{
				$_SESSION['bad_attempt'] =  true;
				include_once 'scripts/view/signin.php';
		        exit();
			}
		}
		catch(PDOException $error){
			echo "Error while login: " . $error;
			exit();
		}
		
 	}
	else if(isset($_POST['operation']) && $_POST['operation'] == 'bought')
	{
		if(isset($_SESSION['logged_id']))
		{
			unset($_SESSION['cart']);
			header('Location: .');
		}
		else
		{
			$_SESSION['notLogged'] = true;
			header('Location: ?signin');
		    exit();
		}	
	}
	else if(isset($_GET['cart']))
	{
		$price = 0;
		$cart = array();
		
		foreach($_SESSION['cart'] as $item)
		{
			$price += $item['price'];
		}
		include_once 'scripts/view/cart.php';
		exit();
		
		
	}
	else if(isset($_GET['signin']))
	{
		include_once 'scripts/view/signin.php';
		exit();
	}
	else if(isset($_GET['logout']))
	{
		unset($_SESSION['cart']);
		unset($_SESSION['logged_id']);
		unset($_SESSION['logged_login']);
		header('Location: .');
		exit();
	}
	else{
		require_once 'scripts/include/database.php';
	    
		if(isset($_GET['category']) && $_GET['category']!= 0 )
		{
			try{
				
				$id = filter_input(INPUT_GET, 'category');
				
				$productsQuery =  $db->prepare('SELECT id, stock, name, description, price FROM products join products_categories on products.id = products_categories.product_id where  products_categories.category_id = :category_id  ');
				$productsQuery->bindValue(':category_id',$id,PDO::PARAM_INT);
				$productsQuery->execute();
				
				$products = $productsQuery->fetchAll();
			
				$categoriesQuery = $db -> query('SELECT * FROM categories');
				$categories = $categoriesQuery->fetchAll();
			
				include_once 'scripts/view/products.php';
			} 
			catch(PDOException $error){
				echo "Error while selecting from database: " .$error;
				exit();		
			};
		}
		else
		{
			try{
				$countQuery = $db->query('SELECT count(id) ci FROM products');
				$count = $countQuery->fetch();
				
				$pages = floor($count['ci'] / 5);
				
				if(!isset($_GET['page']))
				{
					$_GET['page']=0;
				}
				$productsQuery =  $db->query('SELECT * FROM products LIMIT ' . $_GET['page']  . ',10');
				$products = $productsQuery->fetchAll();
			
				$categoriesQuery = $db -> query('SELECT * FROM categories');
				$categories = $categoriesQuery->fetchAll();
			
				include_once 'scripts/view/products.php';
			} 
			catch(PDOException $error){
				echo "Error while selecting from database: " .$error;
				exit();		
			};
		}
	}
	
