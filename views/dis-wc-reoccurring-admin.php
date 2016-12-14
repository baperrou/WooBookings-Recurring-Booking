<style>
	textarea {
		width:700px;
		height: 300px;
	}
</style>

<?php 
    if($_POST['dis_wc_reoccurring']) {
        $required = $_POST['dis_wc_ro_required'];
        update_option('dis_wc_ro_required', $required);
        
        $cost = $_POST['dis_wc_ro_base_cost'];
		update_option('dis_wc_ro_base_cost', $cost);
         
        $course1 = $_POST['dis_wc_ro_course1'];
        update_option('dis_wc_ro_course1', $course1);
        
        $course2 = $_POST['dis_wc_ro_course2'];
        update_option('dis_wc_ro_course2', $course12);
         
              
        $add_on_export = '<div class="updated"><p><strong>Copy and paste this text into the Product Add-on Screen after clicking Import</strong></p></div>';
		$add_on_export .= '<textarea>'.dis_wc_ro_product_addon_export(). '</textarea>';
    } else {
         $required = $_POST['dis_wc_ro_required'];
         $cost = $_POST['dis_wc_ro_base_cost'];
    }
?>
<div class="wrap">
    <?php    echo "<h2>" . __( 'Create Course Lengths For Products', 'pedal_saledm' ) . "</h2>"; ?>
     <p>The detail here needs to be copied and pasted into your re-occurring product Add-on</p>
     <p>Inside the product select 'Add-ons' then 'Import', paste and save</p>
    <form name="oscimp_form" method="post" >
       <input type="hidden" name="dis_wc_reoccurring" value="dis_wc_reoccurring" />
       <table>
        	<tr>
	        	<td colspan="2">
				    <?php _e("Customers are required to choose a length: " ); ?><input type="checkbox" id="dis_wc_ro_required" name="dis_wc_ro_required" value="1"/>
				    <br><span>(If no, then they will be allowed to book a single instance as well as a course)</span>
	        	</td>
        	</tr>
        	<tr>
	        	<td colspan="2">
				    <?php _e("Base cost for single booking block: " ); ?><input type="text" id="dis_wc_ro_base_cost" name="dis_wc_ro_base_cost"/>
				        <br><span>(Numbers only)</span>
	        	</td>
        	</tr>
        	<tr>
	        	<td>Course Length</td>
	        	<td><input type="number" id="dis_wc_ro_course1" name="dis_wc_ro_course1" max="52" /> weeks</td>
        	</tr>
        	<tr>
	        	<td>Course Length</td>
	        	<td><input type="number" id="dis_wc_ro_course2" name="dis_wc_ro_course2" max="52" /> weeks</td>
        	</tr>
        	<tr>
	        	<td>Course Length</td>
	        	<td><input type="number" id="dis_wc_ro_course3" name="dis_wc_ro_course3" max="52" /> weeks</td>
        	</tr>
        	<tr>
	        	<td>Course Length</td>
	        	<td><input type="number" id="dis_wc_ro_course4" name="dis_wc_ro_course4" max="52" /> weeks</td>
        	</tr>
        	<tr>
	        	<td></td>
	        	<td>
 			        <p class="submit">
			        <input type="submit" name="Submit" value="<?php _e('Submit', 'pedal_saledm' ) ?>" />
			        </p>
	        	</td>
        	</tr>
       </table>
    </form>
    <h3>Headline details</h3>
    <p> More Directions</p>
    <p>Such as the base cost here must match your unit cost on the product page.</p>
    <?php echo $add_on_export; ?>
</div>


<?
/*
	/ will need to create json component to copy and paste into Add-ons
	a: 1: {
  i: 0;a: 8: {
    s: 4: "name";s: 13: "Course Length";s: 11: "description";s: 0: "";s: 4: "type";s: 6: "select";s: 8: "position";i: 0;s: 7: "options";a: 3: {
      i: 0;a: 4: {
        s: 5: "label";s: 7: "5 weeks";s: 5: "price";s: 2: "20";s: 3: "min";s: 0: "";s: 3: "max";s: 0: "";
      }i: 1;a: 4: {
        s: 5: "label";s: 7: "7 weeks";s: 5: "price";s: 2: "30";s: 3: "min";s: 0: "";s: 3: "max";s: 0: "";
      }i: 2;a: 4: {
        s: 5: "label";s: 8: "10 weeks";s: 5: "price";s: 2: "45";s: 3: "min";s: 0: "";s: 3: "max";s: 0: "";
      }
    }s: 8: "required";i: 1;s: 32: "wc_booking_person_qty_multiplier";i: 0;s: 31: "wc_booking_block_qty_multiplier";i: 1;
  }
}
 without being required

a: 1: {
  i: 0;a: 8: {
    s: 4: "name";s: 13: "Course Length";s: 11: "description";s: 0: "";s: 4: "type";s: 6: "select";s: 8: "position";i: 0;s: 7: "options";a: 3: {
      i: 0;a: 4: {
        s: 5: "label";s: 7: "5 weeks";s: 5: "price";s: 2: "20";s: 3: "min";s: 0: "";s: 3: "max";s: 0: "";
      }i: 1;a: 4: {
        s: 5: "label";s: 7: "7 weeks";s: 5: "price";s: 2: "30";s: 3: "min";s: 0: "";s: 3: "max";s: 0: "";
      }i: 2;a: 4: {
        s: 5: "label";s: 8: "10 weeks";s: 5: "price";s: 2: "45";s: 3: "min";s: 0: "";s: 3: "max";s: 0: "";
      }
    }s: 8: "required";i: 0;s: 32: "wc_booking_person_qty_multiplier";i: 0;s: 31: "wc_booking_block_qty_multiplier";i: 1;
  }
}
*/
?>

