<div class="panel panel-default">
	<div class="panel-heading">Publishers <a class="btn btn-primary pull-right" href="<?=site_url('admin/publishers/insert')?>">Add</a></div>
<table class="table">
	<?php foreach ($results as $result):?>
	<tr>
		<td><?=$result->offsetGet('n.company')?></td>
		<td>
			<a href="<?=site_url('admin/publishers/view/'.$result->offsetGet('n.id'))?>" title="view"><span class="glyphicon glyphicon-info-sign"></span></a>&nbsp;
			<a href="<?=site_url('admin/publishers/update/'.$result->offsetGet('n.id'))?>" title="edit"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;
			<a href="#" url="<?=site_url('admin/publishers/delete')?>" id="delete_<?=$result->offsetGet('n.id')?>" title="delete" onclick="delete_node(<?=$result->offsetGet('n.id')?>)"><span class=" glyphicon glyphicon-remove-circle"></span></a>
		</td>
	</tr>
	<?php endforeach;?>
</table>
<div class="panel-footer"><?=$links;?></div>
</div>