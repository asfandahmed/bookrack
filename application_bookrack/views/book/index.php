<div class="left-panel col-sm-offset-1 col-md-offset-1 col-sm-offset-1 col-xs-7 col-sm-7 col-md-7 col-lg-7">
<header id="header">  
    <main id="main">
    <div class="container-fluid">
    <div class="container">
    <div class="row topspace">
    <div class="col-sm-8 col-sm-offset-2">
    <div class="container-fluid">
        <div class="col-sm-2 col-md-4 col-lg-4 ">
            <p><img src="<?=base_url('assets/images/book-256.png')?>" class="img-responsive" alt="<?=$book->title?>-photo"/></p>
        </div> 
        <article class="post">
        <header class="entry-header">
        </header> 
        <div class="entry-content"> 
        <h2><?=$book->title?></h2>
        <h2><?=$book->ratings?></h2>
        </br>
        <h4>About the book</h4>
        <p><?=$book->description?></p>
        <h5>ebook, 356 pages</h5></br>
        <h5>Published <?=$book->published_date?> by Vintage</h5>
        <h5>ISBN <?=$book->isbn_10?> (ISBN13: <?=$book->isbn_13?>)</h5>
        </div> 
        </article><!-- #post-## -->

    </div> 
    </div> <!-- /row post  -->

    <div class="row">
    <div class="col-sm-8 col-sm-offset-2">

    <div id="comments"> 
    <h3 class="comments-title">3 Comments</h3>
    <a href="#comment-form" class="leave-comment">Leave a Comment</a>

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

    <div class="comment-body">
    Morbi velit eros, sagittis in facilisis non, rhoncus et erat. Nam posuere tristique sem, eu ultricies tortor imperdiet vitae. Curabitur lacinia neque non metus.
    </div><!-- .comment-body -->
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
    <h3 id="reply-title">Leave a Reply</h3>
    <form action="" method="post" id="commentform" class="">
    <div class="form-group">
    <label for="inputName">Name</label>
    <input type="text" class="form-control" id="inputName" placeholder="Enter your name">
    </div>
    <div class="form-group">
    <label for="inputEmail">Email address <i class="text-danger">*</i></label>
    <input type="email" class="form-control" id="inputEmail" placeholder="Enter your email">
    </div>
    <div class="form-group">
    <label for="inputWeb">Website</label>
    <input type="nane" class="form-control" id="inputWeb" placeholder="http://">
    </div>
    <div class="form-group">
    <label for="inputComment">Comment</label>
    <textarea class="form-control" rows="6"></textarea>
    </div>
    <div class="row">
    <div class="col-md-8">
    <div class="checkbox">
    <label> <input type="checkbox"> Subscribe to updates</label>
    </div>
    </div>
    <div class="col-md-4 text-right">
    <button type="submit" class="btn btn-action">Submit</button>
    </div>
    </form>
    </div> <!-- /respond -->
    </div>
    </div>
    </div> <!-- /row comments -->
    <div class="clearfix"></div>

    </div>  <!-- /container -->

    </main>
</header>
</div>
<div class="right-panel col-sm-3 col-md-3 col-lg-3"></div>
