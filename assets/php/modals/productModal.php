<form method="POST" action="index.php">
<div class="modal-dialog">
    <div class="modal-content" style="border-radius: 1rem;">
      <div class="modal-header" style="background: #1A120B;  color: #FFF8EA; border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
        <h5 class="modal-title" id="exampleModalLabel">Daily Drip</h5>
        <button type="button" class="btn-close" style=" background-color: #fff8ea; color: #fff8ea;" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body d-flex" style="background: #FFF8EA;">
        <div class="modal-img">
            <?php echo '<img src="data:image/png;base64,' .base64_encode($row['prod_img']) . '" />'; ?>
        </div>
        <div class="modal-description-con d-flex flex-column">
            <input type="hidden" name="prod_name" value="<?php echo $row['prod_name']; ?>">
            <input type="hidden" name="prod_price" value="<?php echo $row['prod_price']; ?>">
            <input type="hidden" name="prod_id" value="<?php echo $row['prod_id']; ?>">
            <h5><?php echo $row['prod_name']; ?></h5>
            <div class="prod-description">
                <span><?php echo $row['prod_desc']; ?></span>
            </div>
            <br>
            <div class="quantity">
                <span class="minus">-</span>
                <input role="textbox" type="number" class="count" name="quantity" value="1">
                <span class="plus">+</span>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="add_cart" class="btn" style="background-color: #562B08; color: #fff8ea">Add to Cart</button>
      </div>
    </div>
  </div>
</form>

