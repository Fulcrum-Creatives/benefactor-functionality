<?php
/*global $post;
$num_profiles = wp_count_posts( 'team_member' );
$custom = get_post_custom( $post->ID );
$profile_order 	= ( isset( $custom["profile_order"][0] ) ? $custom["profile_order"][0] : '' );
$nonce = wp_create_nonce( 'benefactor' );	*/
?>
<<!-- input type="hidden" name="wp_meta_box_nonce" value="<?php echo $nonce; ?>" />
<div class="custom-admin">
  <div class="postarea">
    <label for="profile_order">Profile Order</label>
    <select name="profile_order" id="profile_order"> -->
      <?php /*for($i=1;$i<=$num_profiles->publish;$i++):*/?>
        <!-- <option value="<?php echo $i;?>" --> <?php
          /*if($profile_order == $i) echo ' SELECTED ';*/
        ?>><?php /*echo $i;*/?><!-- </option> -->
      <?php /*endfor;*/ ?>
    <!-- </select>
  </div>
</div> -->