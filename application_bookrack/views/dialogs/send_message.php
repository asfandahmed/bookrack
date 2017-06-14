<div class="modal-content">
  <div class="modal-header">
    <div class="row">
    	<div class="col-sm-12 col-md-12 col-lg-12">
    		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    	</div>
    </div>
    <div class="row">
    	<div class="col-sm-6 col-md-6 col-lg-6"><button type="button" class="btn btn-default" id="back_messages" url="<?=site_url('messages/load_message_panel')?>">Back</button></div>
    	<div class="col-sm-6 col-md-6 col-lg-6"><h4 class="modal-title" id="BookrackInbox">Compose Message</h4></div>
    	
    </div>
  </div>
  <?php echo form_open(site_url('messages/send'),array('id'=>'message-form','name'=>'message_form','class'=>'form-horizontal', 'role'=>'form')) ?>
  <div class="modal-body msg_container_base">
  <?php if(isset($email)):?>
    <input type="hidden" name="email" value="<?=urldecode($email)?>" required>
    <input type="hidden" name="check" value="<?=sha1(urldecode($email))?>" required>
    <div id="conversation" style="overflow:auto;max-height:220px;">
    <?php
        if(!empty($messages)):
          $messages = array_reverse($messages);
          $base_url = base_url();
          $userimage = $this->session->userdata('profile_image');
          foreach ($messages as $message): ?>
                      <?php if($message->node->getproperty('u1')==$this->session->userdata('user_id')):?>
                      <div class="row msg_container base_sent">
                        <div class="col-md-10 col-xs-10">
                            <div class="messages msg_sent">
                                <p><?=$message->text;?></p>
                                <time datetime="<?=$message->date_time?>"><?=$message->u1_name;?> • sent <?=$this->utility_functions->time_ago($message->date_time)?></time>
                            </div>
                        </div>
                        <div class="col-md-2 col-xs-2 avatar">
                            <img src="<?=$base_url.'assets/uploads/thumbs/'?><?=empty($userimage)?'user-pic.jpg':$userimage?>" class=" img-responsive ">
                        </div>
                    </div>
                    <?php else:?>
                      <div class="row msg_container base_receive">
                          <div class="col-md-2 col-xs-2 avatar">
                              <img src="<?=$base_url.'assets/uploads/thumbs/'?><?=empty($message->userimage)?'user-pic.jpg':$message->userimage?>" class=" img-responsive ">
                          </div>
                          <div class="col-md-10 col-xs-10">
                              <div class="messages msg_receive">
                                  <p><?=$message->text;?></p>
                                  <time datetime="<?=$message->date_time?>"><?=$message->u2_name;?> • received <?=$this->utility_functions->time_ago($message->date_time)?></time>
                              </div>
                          </div>
                      </div>
                    <?php endif;?>
    <?php endforeach;else: ?>
    <?php endif;?>
    </div>
  <?php else:?>
      <div class="col-xs-offset-1 col-sm-offset-1 col-md-offset-1 col-lg-offset-1 col-xs-10 col-sm-10 col-md-10 col-lg-10">
      <div class="form-group">
        <input type="text" name="email" autocomplete="off" class="form-control" placeholder="email" value="" required>
      </div>
    </div>
  <?php endif;?>
  </div>
  <div class="modal-footer">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="form-group">
        <textarea name="message" class="form-control"  style="resize:none" placeholder="new message" required></textarea>
      </div>
      <input type="submit" name="btn-message-send" class="btn btn-sm btn-primary pull-right" value="send">
    </div>
  </div>
  </form>