<?php $page = basename($_SERVER['SCRIPT_NAME']);  ?>
<ul id="navigation">
    <li <?php if ($page == 'products-list.php') { print ' class="blue"'; } elseif ($page == 'products-view.php') { print ' class="blue"'; } elseif ($page == 'products-update.php') { print ' class="blue"'; } elseif ($page == 'products-delete.php') { print ' class="blue"'; } elseif ($page == 'products-insert.php') { print ' class="blue"'; } ?>><a href="products-list.php">Products</a></li>
    <li <?php if ($page == 'categories-list.php') { print ' class="blue"'; } elseif ($page == 'categories-update.php') { print ' class="blue"'; } elseif ($page == 'categories-delete.php') { print ' class="blue"'; } elseif ($page == 'categories-insert.php') { print ' class="blue"'; } ?>><a href="categories-list.php">Categories</a></li>
    <li <?php if ($page == 'materials-list.php') { print ' class="blue"'; } elseif ($page == 'materials-update.php') { print ' class="blue"'; } elseif ($page == 'materials-delete.php') { print ' class="blue"'; } elseif ($page == 'materials-insert.php') { print ' class="blue"'; } ?>><a href="materials-list.php">Materials</a></li>
    <li <?php if ($page == 'brands-list.php') { print ' class="blue"'; } elseif ($page == 'brands-update.php') { print ' class="blue"'; } elseif ($page == 'brands-delete.php') { print ' class="blue"'; } elseif ($page == 'brands-insert.php') { print ' class="blue"'; } ?>><a href="brands-list.php">Brands</a></li>
    <li <?php if ($page == 'colors-list.php') { print ' class="blue"'; } elseif ($page == 'colors-update.php') { print ' class="blue"'; } elseif ($page == 'colors-delete.php') { print ' class="blue"'; } elseif ($page == 'colors-insert.php') { print ' class="blue"'; } ?>><a href="colors-list.php">Colors</a></li>
    <li <?php if ($page == 'links-list.php') { print ' class="blue"'; } elseif ($page == 'links-update.php') { print ' class="blue"'; } elseif ($page == 'links-delete.php') { print ' class="blue"'; } elseif ($page == 'links-insert.php') { print ' class="blue"'; } ?>><a href="links-list.php">Links</a></li>
    <li <?php if ($page == 'stores-list.php') { print ' class="blue"'; } elseif ($page == 'stores-update.php') { print ' class="blue"'; } elseif ($page == 'stores-delete.php') { print ' class="blue"'; } elseif ($page == 'stores-insert.php') { print ' class="blue"'; } ?>><a href="stores-list.php">Stores</a></li>
    <li <?php if ($page == 'careers-list.php') { print ' class="blue"'; } elseif ($page == 'careers-update.php') { print ' class="blue"'; } elseif ($page == 'careers-delete.php') { print ' class="blue"'; } elseif ($page == 'careers-insert.php') { print ' class="blue"'; } ?>><a href="careers-list.php">Careers</a></li>
    <?php if(isset($_SESSION['suser_type']) && $_SESSION['suser_type']==1)	{
			echo '<li';
			if ($page == 'users-list.php') { print ' class="blue"'; } elseif ($page == 'user-update.php') { print ' class="blue"'; } elseif ($page == 'user-delete.php') { print ' class="blue"'; } elseif ($page == 'user-insert.php') { print ' class="blue"'; }
			echo '>  | <a href="users-list.php">Users</a></li>'; } ?>
</ul>