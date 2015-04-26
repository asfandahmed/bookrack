<div id="bookinfo-form" class="col-sm-5 col-md-5 col-lg-5">
  <?php echo validation_errors(); ?>
  <?php echo form_open($post_url,array('class'=>'form-horizontal', 'role'=>'form')) ?>
      <div class="form-group">
      <label for="inputCompany" class="col-sm-4 col-md-4 col-lg-4 control-label">Company</label>
      <div class="col-sm-7 col-md-7 col-lg-7">
        <input type="text" name="company" value="<?=isset($company)?$company:set_value('company'); ?>" class="form-control" id="inputCompany" placeholder="Company">
      </div>
      </div>
      <?=isset($id)?form_hidden('id',$id):""?>
    <div class="form-group">
      <input type="submit" name="register" value="<?=$buttonText?>" class="col-sm-offset-2 col-md-offset-2 col-lg-offset-2 col-sm-5 col-md-5 col-lg-5 btn btn-primary">
    </div>

  </form>
</div>