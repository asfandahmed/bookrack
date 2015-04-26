<script type="text/javascript">
$(document).ready(function(){
	$( "#add_shelf" ).autocomplete({
		delay:500,
		minLength:3,
		source: "<?=site_url('search/books')?>",
	});
});
</script>
<div class="row">
	<div class="left-panel col-sm-offset-1 col-md-offset-1 col-sm-offset-1 col-sm-2 col-md-2 col-lg-2">
		<?php $this->load->view('user/profile_info_section.php')?>
	</div>
	<div class="middle-content col-sm-5 col-md-5 col-lg-5">
		<?php if($owner):?>
		<div class="col-sm-12 col-md-12 col-lg-12 custom-panel post">
		<?php echo form_open(site_url('shelf'),array('class'=>'form-horizontal', 'role'=>'form','id'=>'book-form')) ?>
			<div class="col-sm-12 col-md-12 col-lg-12">
				<div class="input-group">
					<input type="text" id="add_shelf" name="add_shelf" class="form-control" placeholder="add to shelf">
					<div class="input-group-btn"><button type="submit" onclick="add_books()" class="btn btn-primary">Add</div>
				</div>
			</div>
		</form>
		</div>
		<?php endif;?>
		<div class="row">
			<?php $this->load->view('user/book_box.php')?>
		</div>
	</div>
	<div class="right-panel col-sm-3 col-md-3 col-lg-3">
		<?php $this->load->view('site/suggestions.php')?>
	</div>
</div>