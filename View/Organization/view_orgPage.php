<div class="container text-center">
	<h1><?php echo $orgTitle?></h1>
</div>
<div class="form-group pull-right">
	<input type="text" class="search form-control" placeholder="What you looking for?">
</div>
<span class="counter pull-right"></span>

	<table class="table table-striped table-hover table-bordered results">
		<thead>
		<tr>
			<th>#</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Username</th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<th scope="row">1</th>
			<td>Mark</td>
			<td>Otto</td>
			<td>@mdo</td>
		</tr>
		<tr>
			<th scope="row">2</th>
			<td>Jacob</td>
			<td>Thornton</td>
			<td>@fat</td>
		</tr>
		<tr>
			<th scope="row">3</th>
			<td>Larry</td>
			<td>the Bird</td>
			<td>@twitter</td>
		</tr>
		</tbody>
	</table>
<ul class="pagination">
	<?php
	foreach ($pagination as $key => $item) {
		echo "<li><a href=\"".($item+1)."\">".($key+1)."</a></li>";
	}
	?>
</ul>