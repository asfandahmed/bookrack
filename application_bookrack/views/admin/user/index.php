<div class="panel panel-default">
	<div class="panel-heading">Users <a class="btn btn-primary pull-right" href="<?=site_url('admin/users/insert')?>">Add</a></div>
<table class="table">
	
	<?php foreach ($results as $result):?>
	<tr>
		<td><?=$result->offsetGet('name')?></td>
		<td>
			<a href="<?=site_url('admin/users/view/'.$result->offsetGet('n.id'))?>" title="view"><span class="glyphicon glyphicon-info-sign"></span></a>&nbsp;
			<a href="<?=site_url('admin/users/update/'.$result->offsetGet('n.id'))?>" title="edit"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;
			<a href="#" url="<?=site_url('admin/users/delete')?>" id="delete_<?=$result->offsetGet('n.id')?>" title="delete" onclick="delete_node(<?=$result->offsetGet('n.id')?>)"><span class=" glyphicon glyphicon-remove-circle"></span></a>
		</td>
	</tr>
	<?php endforeach;?>
</table>
<div class="panel-footer"><?=$links;?></div>
</div>