<style>
	textarea {
		width:700px;
		height: 300px;
	}
</style>

<?php 
    if($_POST['dis_wc_recurring']) {
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
     <p>The detail here needs to be copied and pasted into your recurring product Add-on</p>
     <p>Inside the product select 'Add-ons' then 'Import', paste and save</p>
    <form name="oscimp_form" method="post" >
       <input type="hidden" name="dis_wc_recurring" value="dis_wc_reoccurring" />
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


