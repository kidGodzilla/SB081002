<?php while ($row = mysql_fetch_assoc($resultLink)) { ?>
    <p><input name="link_<?php echo $row['link_id']; ?>" type="checkbox" value="<?php echo $row['link_name']; ?>" /> <?php echo $row['link_name']; ?></p>
    <?php } ?>