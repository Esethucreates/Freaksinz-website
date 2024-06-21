<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
?>


<header>
    <section class="category-header">
        <div class="filter-box">

            <nav class="ui pointing menu filter-bar">
                <a class="item" href="../userFunctions/shop.php">All products</a>
                <?php
$category = $connDB->prepare("SELECT * FROM `products`");
$category->execute();
if ($category->rowCount() > 0) {
    $seen_categories = []; 
    while ($fetch_products = $category->fetch(PDO::FETCH_ASSOC)) {
        $category_name = $fetch_products['category'];
        if (!in_array($category_name, $seen_categories)) {        
?>
                <a class="item" href="../userFunctions/category.php?category=<?= $category_name; ?>">
                    <?= $category_name; ?>
                </a>
                <?php            
            $seen_categories[] = $category_name;
        }
    }
}
?>
            </nav>


            <div id="filter" class="ui dropdown">
                More
                <i class=" dropdown icon"></i>

                <div class="menu ">
                    <a class="item" href="../userFunctions/shop.php">All products</a>
                    <?php
$category = $connDB->prepare("SELECT * FROM `products`");
$category->execute();
if ($category->rowCount() > 0) {
    $seen_categories = []; 
    while ($fetch_products = $category->fetch(PDO::FETCH_ASSOC)) {
        $category_name = $fetch_products['category'];
        if (!in_array($category_name, $seen_categories)) {        
?>
                    <a class="item" href="../userFunctions/category.php?category=<?= $category_name; ?>">
                        <?= $category_name; ?>
                    </a>
                    <?php            
            $seen_categories[] = $category_name;
        }
    }
}
?>
                </div>
            </div>
        </div>
    </section>


</header>