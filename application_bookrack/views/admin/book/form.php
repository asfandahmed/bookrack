<script type="text/javascript">
$(document).ready(function(){
  $( "#inputAuthor" ).autocomplete({
    delay:500,
    minLength:2,
    source: "<?=site_url('search/authors')?>",
  });
  $( "#inputPublisher" ).autocomplete({
    delay:500,
    minLength:2,
    source: "<?=site_url('search/publishers')?>",
  });
});
</script>
<div id="bookinfo-form" class="col-sm-5 col-md-5 col-lg-5">
  <?php echo validation_errors(); ?>
  <?php echo form_open($post_url,array('class'=>'form-horizontal', 'role'=>'form')) ?>
    
      <div class="form-group">
      <label for="inputTitle" class="col-sm-4 col-md-4 col-lg-4 control-label">Title</label>
      <div class="col-sm-7 col-md-7 col-lg-7">
        <input type="text" name="title" value="<?=isset($title)?$title:set_value('title'); ?>" class="form-control" id="inputTitle" placeholder="Title">
      </div>
      </div>

      <div class="form-group">
      <label for="inputDescription" class="col-sm-4 col-md-4 col-lg-4 control-label">Description</label>
      <div class="col-sm-7 col-md-7 col-lg-7">
        <input type="text" name="description" value="<?=isset($description)?$description:set_value('description'); ?>" class="form-control" id="inputDescription" placeholder="Discription">
      </div>
      </div>

      <div class="form-group">
      <label for="inputAuthor" class="col-sm-4 col-md-4 col-lg-4 control-label">Author</label>
      <div class="col-sm-7 col-md-7 col-lg-7">
        <input type="text" name="author" value="<?=isset($author)?$author:set_value('author'); ?>" class="form-control" id="inputAuthor" placeholder="Author">
      </div>
      </div>

      <div class="form-group">
      <label for="inputPublisher" class="col-sm-4 col-md-4 col-lg-4 control-label">Publisher</label>
      <div class="col-sm-7 col-md-7 col-lg-7">
        <input type="text" name="publisher" value="<?=isset($publisher)?$publisher:set_value('publisher'); ?>" class="form-control" id="inputPublisher" placeholder="Publisher">
      </div>
      </div>

      <div class="form-group">
      <label for="inputPublished" class="col-sm-4 col-md-4 col-lg-4 control-label">Published Date</label>
      <div class="col-sm-7 col-md-7 col-lg-7">
        <input type="text" name="published_date" value="<?=isset($published_date)?$published_date:set_value('published_date'); ?>" class="form-control" id="inputPublished" placeholder="Published">
      </div>
      </div>

      <div class="form-group">
      <label for="inputEdition" class="col-sm-4 col-md-4 col-lg-4 control-label">Edition</label>
      <div class="col-sm-7 col-md-7 col-lg-7">
        <input type="text" name="edition" value="<?=isset($edition)?$edition:set_value('published_date'); ?>" class="form-control" id="inputEdition" placeholder="Edition">
      </div>
      </div>

      <div class="form-group">
      <label for="inputISBN10" class="col-sm-4 col-md-4 col-lg-4 control-label">ISBN-10</label>
      <div class="col-sm-7 col-md-7 col-lg-7">
        <input type="text" name="isbn_10" value="<?=isset($isbn_10)?$isbn_10:set_value('isbn_10'); ?>" class="form-control" id="inputISBN10" placeholder="ISBN-10">
      </div>
      </div>

     <div class="form-group">
      <label for="inputISBN13" class="col-sm-4 col-md-4 col-lg-4 control-label">ISBN-13</label>
      <div class="col-sm-7 col-md-7 col-lg-7">
        <input type="text" name="isbn_13" value="<?=isset($isbn_13)?$isbn_13:set_value('isbn_13'); ?>" class="form-control" id="inputISBN13" placeholder="ISBN-13">
      </div>
      </div>

      <div class="form-group">
      <label for="inputGenre" class="col-sm-4 col-md-4 col-lg-4 control-label">Genre</label>
      <div class="col-sm-7 col-md-7 col-lg-7">
        <select name="genre" class="form-control" id="inputGenre">
          <?php foreach ($genres as $key => $value):?>
            <option value="<?=$key?>"><?=ucfirst($value)?></option>
          <?php endforeach;?>
        </select>
      </div>
      </div>

      <div class="form-group">
      <label for="inputLanguage" class="col-sm-4 col-md-4 col-lg-4 control-label">Language</label>
      <div class="col-sm-7 col-md-7 col-lg-7">
        <select name="language" class="form-control" id="inputLanguage">
          <option value="English" <?php if(isset($language)){ if($language=="English") echo 'selected="true"'; }?>>English</option>
          <option value="Urdu"<?php if(isset($language)){ if($language=="Urdu") echo 'selected="true"'; }?>>Urdu</option>
          <option value="Sindhi" <?php if(isset($language)){ if($language=="Sindhi") echo 'selected="true"'; }?>>Sindhi</option>
        </select>
      </div>
      </div>

      <div class="form-group">
      <label for="inputRatings" class="col-sm-4 col-md-4 col-lg-4 control-label">Ratings</label>
      <div class="col-sm-7 col-md-7 col-lg-7">
        <select name="ratings" class="form-control" id="inputRatings">
          <option value="1" <?php if(isset($ratings)){ if($ratings==1) echo 'selected="true"'; }?> >1</option>
          <option value="2" <?php if(isset($ratings)){ if($ratings==2) echo 'selected="true"'; }?> >2</option>
          <option value="3" <?php if(isset($ratings)){ if($ratings==3) echo 'selected="true"'; }?> >3</option>
          <option value="4" <?php if(isset($ratings)){ if($ratings==4) echo 'selected="true"'; }?> >4</option>
          <option value="5" <?php if(isset($ratings)){ if($ratings==5) echo 'selected="true"'; }?> >5</option>
        </select>
      </div>
      </div>

      <div class="form-group">
      <label for="inputRatings" class="col-sm-4 col-md-4 col-lg-4 control-label">Pages</label>
      <div class="col-sm-7 col-md-7 col-lg-7">
        <input type="text" name="total_pages" value="<?=isset($total_pages)?$total_pages:set_value('total_pages'); ?>" class="form-control" id="inputPages" placeholder="Total pages">
      </div>
      </div>

      <div class="form-group">
      <label for="inputImages" class="col-sm-4 col-md-4 col-lg-4 control-label">Images</label>
      <div class="col-sm-7 col-md-7 col-lg-7">
        <input type="text" class="form-control" id="inputImages" placeholder="Images">
      </div>
      </div>
    <?=isset($id)?form_hidden('id',$id):""?>
    <div class="form-group">
      <input type="submit" name="register" class="col-sm-offset-2 col-md-offset-2 col-lg-offset-2 col-sm-5 col-md-5 col-lg-5 btn btn-primary" value="<?=$buttonText?>">
    </div>

  </form>
</div>