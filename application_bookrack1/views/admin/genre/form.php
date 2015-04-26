<div id="BookInfo-form" class="col-sm-5 col-md-5 col-lg-5">
  <?php echo validation_errors(); ?>
  <?php echo form_open($post_url,array('class'=>'form-horizontal', 'role'=>'form')) ?>
    
    <div class="form-group">
      <label for="inputName" class="col-sm-2 control-label">Name</label>
      <div class="col-sm-7 col-md-7 col-lg-7">
        <input type="text" name="name" value="<?=isset($name)?$name:set_value('title'); ?>" class="form-control" id="inputName" placeholder="Name">
        <?=isset($id)?form_hidden('id',$id):""?>
      </div>
      </div>

      <div class="form-group">
        <input type="submit" name="register" class="col-sm-offset-2 col-md-offset-2 col-lg-offset-2 col-sm-3 col-md-3 col-lg-3 btn btn-primary" value="<?=$buttonText?>">
      </div>
  </form>
</div>