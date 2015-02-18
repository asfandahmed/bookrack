<div id="bookinfo-form" class="col-sm-5 col-md-5 col-lg-5">
  <?php echo validation_errors(); ?>
  <?php echo form_open($post_url,array('class'=>'form-horizontal', 'role'=>'form')) ?>
    
      <div class="form-group">
      <label for="inputName" class="col-sm-4 col-md-4 col-lg-4 control-label">Name</label>
      <div class="col-sm-7 col-md-7 col-lg-7">
        <input type="text" name="name" value="<?=isset($name)?$name:set_value('name'); ?>" class="form-control" id="inputName" placeholder="Name">
      </div>
      </div>

      <div class="form-group">
      <label for="inputAddress" class="col-sm-4 col-md-4 col-lg-4 control-label">Address</label>
      <div class="col-sm-7 col-md-7 col-lg-7">
        <input type="text" name="address" value="<?=isset($address)?$address:set_value('address'); ?>" class="form-control" id="inputAddress" placeholder="Address">
      </div>
      </div>

      <div class="form-group">
      <label for="inputContact" class="col-sm-4 col-md-4 col-lg-4 control-label">Contact</label>
      <div class="col-sm-7 col-md-7 col-lg-7">
        <input type="text" name="contact" value="<?=isset($contact)?$contact:set_value('contact'); ?>" class="form-control" id="inputContact" placeholder="Contact">
      </div>
      </div>
      <?=isset($id)?form_hidden('id',$id):""?>
    <div class="form-group">
      <input type="submit" name="register" class="col-sm-offset-2 col-md-offset-2 col-lg-offset-2 col-sm-5 col-md-5 col-lg-5 btn btn-primary" value="<?=$buttonText?>">
    </div>

  </form>
</div>