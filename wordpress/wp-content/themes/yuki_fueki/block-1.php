<aside>
  <h2 class="h_style">CATEGORY</h2>
  <ul>
    <!-- <li><a href="category.html">仕事</a></li>
    <li><a href="category.html">生活</a></li>
    <li><a href="category.html">雑記</a></li> -->
    <?php
    $categories = get_categories();
    foreach( $categories as $category ):
      $cat_link = get_category_link( $category->term_id );
      $cat_str = $category->name;
      echo '<li><a href="'. $cat_link .'">'. $cat_str .'</a></li>';
    endforeach;
    ?>
  </ul>
</aside>
