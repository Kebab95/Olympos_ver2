<div class="row" xmlns="http://www.w3.org/1999/html">
	<div class="col-md-12">
		<h1 class="text-center">Olympos</h1>
	</div>
</div>

<div class="row">
	<div class="<?php echo ((isset($ContestArray) &&count($ContestArray)>0)?"col-md-7":"col-md-12")?>">
		<div class="panel panel-default">
			<div class="panel-heading">
				Éppen futó versenyek
			</div>
			<div class="panel-body">
				<?php
				if(count($actualContestArray)>0){
					foreach ($actualContestArray as $item) {
						?>
							<div class="row">
								<div class="col-md-4"><?php echo $item[DBData::$contestName]?></div>
								<div class="col-md-4"></div>
								<div class="col-md-4"></div>
							</div>
						<hr>
						<?php
					}
				}
				else {
					echo '<div class="row"><div class="col-md-4"></div><div class="col-md-4">Nincsenek aktuális versenyek</div><div class="col-md-4"></div> </div>';
				}
				?>
			</div>
		</div>
	</div>
	<?php
	if(isset($ContestArray) &&count($ContestArray)>0){
	?>
	<div class="col-md-5">
			<div class="panel panel-default">
				<div class="panel-heading">
					<label>Saját versenyek</label>
				</div>
				<div class="panel-body">
					<?php
					/** @var Contest $contest */
					foreach ($ContestArray as $contest) {
						?>
							<div class="row">
								<div class="col-md-4"><?php echo $contest->getName()?></div>
								<div class="col-md-4"><?php echo $contest->getDate()?></div>
								<div class="col-md-4"><a href="?contestview=<?php echo $contest->getId()?>" <button>Tovább</button></a></div>
							</div>
						<hr>
						<?php
					}
					?>
				</div>
			</div>


	</div>
	<?php
	}
	?>
</div>

<div class="row">
	<div class="col-md-4 panel panel-default">
		<div class="panel-body">
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis nec nisi vel felis varius placerat eu ac mauris. Donec dui tellus, tincidunt eu felis non, euismod bibendum orci. Maecenas non dolor vel massa facilisis rutrum. Maecenas quis pellentesque neque. Nullam eu magna vel enim egestas suscipit. Curabitur semper libero at interdum finibus. Pellentesque vestibulum hendrerit ipsum id malesuada. Phasellus vitae felis sem. Duis id lectus augue. Etiam nibh enim, semper vel leo ultricies, placerat tempor purus. Sed a metus vitae nulla mattis tempor. Vestibulum sodales sapien a ex ultrices fringilla. Sed non ipsum interdum, commodo enim in, pulvinar sapien. Interdum et malesuada fames ac ante ipsum primis in faucibus. Fusce vitae ipsum feugiat, tempor elit quis, lobortis augue.

			Donec pellentesque luctus auctor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Sed sagittis a felis ut pellentesque. Curabitur ligula metus, mollis quis libero quis, scelerisque facilisis erat. Suspendisse et tellus eu justo interdum finibus eu ac mauris. Donec ultricies nisl id velit tincidunt tempor. Sed magna nisl, sollicitudin non enim ut, ultricies cursus elit. Aliquam ultricies eu mi ac rhoncus. Phasellus semper mi a lorem rhoncus, facilisis ultricies metus dictum.
		</div>
	</div>
	<div class="col-md-4 panel panel-primary">
		<div class="panel-body">
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis nec nisi vel felis varius placerat eu ac mauris. Donec dui tellus, tincidunt eu felis non, euismod bibendum orci. Maecenas non dolor vel massa facilisis rutrum. Maecenas quis pellentesque neque. Nullam eu magna vel enim egestas suscipit. Curabitur semper libero at interdum finibus. Pellentesque vestibulum hendrerit ipsum id malesuada. Phasellus vitae felis sem. Duis id lectus augue. Etiam nibh enim, semper vel leo ultricies, placerat tempor purus. Sed a metus vitae nulla mattis tempor. Vestibulum sodales sapien a ex ultrices fringilla. Sed non ipsum interdum, commodo enim in, pulvinar sapien. Interdum et malesuada fames ac ante ipsum primis in faucibus. Fusce vitae ipsum feugiat, tempor elit quis, lobortis augue.

			Donec pellentesque luctus auctor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Sed sagittis a felis ut pellentesque. Curabitur ligula metus, mollis quis libero quis, scelerisque facilisis erat. Suspendisse et tellus eu justo interdum finibus eu ac mauris. Donec ultricies nisl id velit tincidunt tempor. Sed magna nisl, sollicitudin non enim ut, ultricies cursus elit. Aliquam ultricies eu mi ac rhoncus. Phasellus semper mi a lorem rhoncus, facilisis ultricies metus dictum.
		</div>
	</div>
	<div class="col-md-4 panel panel-info">
		<div class="panel-body">
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis nec nisi vel felis varius placerat eu ac mauris. Donec dui tellus, tincidunt eu felis non, euismod bibendum orci. Maecenas non dolor vel massa facilisis rutrum. Maecenas quis pellentesque neque. Nullam eu magna vel enim egestas suscipit. Curabitur semper libero at interdum finibus. Pellentesque vestibulum hendrerit ipsum id malesuada. Phasellus vitae felis sem. Duis id lectus augue. Etiam nibh enim, semper vel leo ultricies, placerat tempor purus. Sed a metus vitae nulla mattis tempor. Vestibulum sodales sapien a ex ultrices fringilla. Sed non ipsum interdum, commodo enim in, pulvinar sapien. Interdum et malesuada fames ac ante ipsum primis in faucibus. Fusce vitae ipsum feugiat, tempor elit quis, lobortis augue.

			Donec pellentesque luctus auctor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Sed sagittis a felis ut pellentesque. Curabitur ligula metus, mollis quis libero quis, scelerisque facilisis erat. Suspendisse et tellus eu justo interdum finibus eu ac mauris. Donec ultricies nisl id velit tincidunt tempor. Sed magna nisl, sollicitudin non enim ut, ultricies cursus elit. Aliquam ultricies eu mi ac rhoncus. Phasellus semper mi a lorem rhoncus, facilisis ultricies metus dictum.
		</div>
	</div>
</div>



