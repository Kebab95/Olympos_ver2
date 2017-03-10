<div id="adminBody">
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					Jegyzői bejelentkezés
				</div>
				<div class="panel-body text-center">
					Kérjük a bejelentkezési kódot:
					<input type="text" class="form-control" id="adminLoginCode">
				</div>
				<div class="panel-footer">
					<button class="btn btn-success btn-block" onclick="adminLogin()">Bejelentkezés</button>
				</div>
			</div>
		</div>
		<div class="col-md-4"></div>
	</div>
</div>
<script>
	function adminLogin(){
		var loginCode = $("#adminLoginCode").val();
		if(loginCode.length>0){
			$.ajax({
				url:'Model/contestView/adminLog/model_ajax_loginAdmin.php',
				type: 'POST',
				data: {code:loginCode,
					contestID: <?php echo $_GET["contestview"]?>},
				dataType:'html'
			}).done(function(data){
				//console.log(data);

				$('#adminBody').fadeOut(500, function() {
					//this is a callback once the element has finished hiding

					//populate the div with whatever was returned from the ajax call
					$(this).html(data);
					//fade in with new content
					$(this).fadeIn(500);
				});
			}).fail(function(){
				alert("Hiba!");
			});
		}
		else {
			alert("Nem írt be kódot")
		}

	}
	function adminOpenCategory(adminID,cccID){
		if(cccID !="" && cccID != null && adminID!="" &&adminID!=null){
			$.ajax({
				url:'Model/contestView/adminLog/model_ajax_adminCatView.php',
				type: 'POST',
				data: {adminID: adminID,cccID:cccID},
				dataType:'html'
			}).done(function(data){
				//console.log(data);

				$('#adminBody').fadeOut(500, function() {
					//this is a callback once the element has finished hiding

					//populate the div with whatever was returned from the ajax call
					$(this).html(data);
					//fade in with new content
					$(this).fadeIn(500);
				});
			}).fail(function(){
				alert("Hiba!");
			});
		}
		else {
			alert("Hiba")
		}
	}

</script>