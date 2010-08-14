<div class="top-bump">
	<?=ui_widget_start()?>
		<?=ui_widget_header('Dashboard')?>
		<?=ui_widget_container_start()?>
		
			<div class="stats-mod">
				<div class="stat"><p><b>Total Accounts:</b> <?=count($customers)?></p></div>
				<div class="stat"><p><b>Accounts Today:</b> <?=$todaycount?></p></div>
			</div>
			
			<table class="data-table">
				<thead>
					<tr>
						<th>Date</th>
						<th>First</th>
						<th>Last</th>
						<th>Email</th>
						<th>Company</th>
						<th>Url</th>
						<th>Source</th>
						<th>Views</th>
					</tr>
				</thead>
				
				<tbody>
					<?php foreach($customers AS $key => $row) : ?>
					<tr>
						<td><?=date('n/j/y', strtotime($row['Config']['accountstart']))?></td>
						<td><?=$row['UsersFirstName']?></td>
						<td><?=$row['UsersLastName']?></td>
						<td><?=$row['UsersEmail']?></td>
						<td><?=$row['Config']['displayname']?></td>
						<td><?=$row['Config']['namespace']?></td>
						<td><?=$row['Config']['clicktrack']?></td>
						<td><?=$row['PageTrackerCount']?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
	
		<?=ui_widget_container_end()?>
	<?=ui_widget_end()?>
</div>