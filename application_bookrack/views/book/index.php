<div class="left-panel col-md-offset-1 col-sm-offset-1 col-xs-12 col-sm-12 col-md-10 col-lg-10">
    <header id="header">  
        <main id="main">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-margin-padding">
                    <div class="row">   
                    <div class="col-sm-2 col-md-3 col-lg-3 ">
                        <p><img src="<?=base_url('assets/images/book-256.png')?>" class="img-responsive" alt="<?=$book->title?>-photo"/></p>
                    </div> 
                    <article class="post">
                    <header class="entry-header">
                    </header> 
                    <div class="entry-content"> 
                        <h2><?=ucfirst($book->title)?></h2>
                        <h6>Rating <?=empty($book->ratings)?'Not available':$book->ratings;?></h6>
                        <br/>
                        <h4>About the book</h4>
                        <p><?=$book->description?></p>
                        <h5><?=($book->total_pages>1)?$book->total_pages.' pages':$book->total_pages.' page';?></h5><br/>
                        <h5>Published <?=$book->published_date?> by Vintage</h5>
                        <h5>ISBN <?=$book->isbn_10?> (ISBN13: <?=$book->isbn_13?>)</h5><br>
                    </div> 
                    </article><!-- #post-## -->
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 pull-right">
                        <nav>
                            <ul>
                                <li><a href=""><span>Add to wishlist</span></a></li>
                            </ul>    
                        </nav>
                    </div>
                </div> <!-- /row post  -->
                </div>
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2">

                <div id="comments"> 
                    <h3 class="comments-title">3 Reviews</h3>
                    <a href="#comment-form" class="leave-comment">Post a Review</a>

                    <ol class="comments-list">
                        <li class="comment">
                            <div>
                            <img src="assets/images/avatar_man.png" alt="Avatar" class="avatar">

                            <div class="comment-meta">
                            <span class="author"><a href="#">John Doe</a></span>
                            <span class="date"><a href="#">January 22, 2011 at 4:55 pm</a></span>
                            <span class="reply"><a href="#">Reply</a></span>
                            </div>

                            <div class="comment-body">
                            Morbi velit eros, sagittis in facilisis non.
                            </div>
                            </div>

                            <ul class="children">
                            <li class="comment">
                                <div>
                                    <img src="assets/images/avatar_man.png" alt="Avatar" class="avatar">

                                    <div class="comment-meta">
                                    <span class="author"><a href="#">John Doe</a></span>
                                    <span class="date"><a href="#">January 22, 2011 at 4:55 pm</a></span>
                                    <span class="reply"><a href="#">Reply</a></span>
                                    </div><!-- .comment-meta -->
                                    <div class="comment-body">Morbi velit eros, sagittis in facilisis non, rhoncus et erat. Nam posuere tristique sem, eu ultricies tortor imperdiet vitae. Curabitur lacinia neque non metus.</div><!-- .comment-body -->
                                </div>
                                </li>
                            </ul><!-- .children -->
                        </li>

                        <li class="comment">
                            <div>
                            <img src="assets/images/avatar_woman.png" alt="Avatar" class="avatar">

                            <div class="comment-meta">
                            <span class="author"><a href="#">Jonnes</a></span>
                            <span class="date"><a href="#">January 22, 2011 at 4:55 pm</a></span>
                            <span class="reply"><a href="#">Reply</a></span>
                            </div><!-- .comment-meta -->

                            <div class="comment-body">
                            Morbi velit eros, sagittis in facilisis non, rhoncus et erat. Nam posuere tristique sem, eu ultricies tortor imperdiet vitae. Curabitur lacinia neque non metus.                        </div><!-- .comment-body -->
                            </div>
                        </li>
                    </ol>

                    <div class="clearfix"></div>

                    <nav id="comment-nav-below" class="comment-navigation clearfix" role="navigation"><div class="nav-content">
                    <div class="nav-previous">&larr; Older Comments</div>
                    <div class="nav-next">Newer Comments &rarr;</div>
                    </div></nav><!-- #comment-nav-below -->


                    <div id="respond">
                    <?php if($this->utility_functions->is_logged_in()):?>
                    <h3 id="reply-title">Post a Review</h3>
                    <?php echo form_open(site_url('post/review'),array('method'=>'post','id'=>'commentform'))?>
                        <input type="hidden" name="strrv" value="<?=sha1($book->id)?>">
                        <input type="hidden" name="bookId" value="<?=$book->id?>">
                        <div class="form-group">
                        <label for="inputReview">Review</label>
                        <textarea name="review" class="form-control" rows="6"></textarea>
                        </div>
                        <div class="row">
                        <div class="col-md-8"></div>
                        <div class="col-md-4 text-right">
                        <button type="submit" class="btn btn-action">Submit</button>
                        </div>
                    </form>
                    <?php else:?>
                    <h4><a href="<?=site_url('login')?>">Login to post a review</a></h4>
                    <?php endif;?>
                    </div> <!-- /respond -->
                </div>
                </div>
            </div> <!-- /row comments -->
            <div class="clearfix"></div>
            </div>  <!-- /container -->
        </main>
    </header>
</div>