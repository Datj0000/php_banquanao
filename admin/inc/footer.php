</div>
</div>
<!-- END MAIN CONTENT -->
</div>
<!-- END MAIN -->
<div class="clearfix"></div>
<footer>
	<div class="container-fluid">
		<p class="copyright">&copy; 2021 <a href="#" target="_blank">Theme I Need</a>. All Rights Reserved.</p>
	</div>
</footer>
</div>
<!-- END WRAPPER -->
<!-- Javascript -->
<script src="assets/vendor/jquery/jquery.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	$('#table').DataTable({
		responsive: true,
	});
	$('#table2').DataTable({
		responsive: true,
		searching: false,
		paging: false,
		order: false,
        bLengthChange: false,
	});
</script>
<script src="https://ckeditor.com/apps/ckfinder/3.5.0/ckfinder.js"></script>
<script src="../ckfinder/ckfinder.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/28.0.0/classic/ckeditor.js"></script>
<script>
	var editor = ClassicEditor
		.create(document.querySelector('#dess'))
		.catch(error => {
			console.error(error)
		});
	CKFinder.setupCKEditor(editor)
</script>
<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="assets/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
<script src="assets/vendor/chartist/js/chartist.min.js"></script>
<script src="assets/scripts/klorofil-common.js"></script>
<script>
	function ShowImagePreview(imageUploader, previewImage) {
		if (imageUploader.files && imageUploader.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$(previewImage).attr('src', e.target.result);
			}
			reader.readAsDataURL(imageUploader.files[0]);
		}
	}

	function ShowImagePreview2(imageUploader, previewImage) {
		if (imageUploader.files && imageUploader.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$(previewImage).attr('src', e.target.result);
			}
			reader.readAsDataURL(imageUploader.files[0]);
		}
	}
</script>
</body>

</html>