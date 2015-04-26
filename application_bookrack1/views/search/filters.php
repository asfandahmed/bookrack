<div class="list-group">
  <a href="<?=site_url('search')?>?search=<?=$keywords?>&amp;filter=anything" class="list-group-item <?=($filters=='anything'||$filters=="")?"active":""?>">Anything</a>
  <a href="<?=site_url('search')?>?search=<?=$keywords?>&amp;filter=books" class="list-group-item <?=($filters=='books')?"active":""?>" >Books</a>
  <a href="<?=site_url('search')?>?search=<?=$keywords?>&amp;filter=people" class="list-group-item <?=($filters=='people')?"active":""?>">People</a>
  <a href="<?=site_url('search')?>?search=<?=$keywords?>&amp;filter=authors" class="list-group-item <?=($filters=='authors')?"active":""?>">Authors</a>
  <a href="<?=site_url('search')?>?search=<?=$keywords?>&amp;filter=publishers" class="list-group-item <?=($filters=='publishers')?"active":""?>">Publishers</a>
</div>