<?php
final class SolutionTrainView
{

	private function __construct()
	{

	}

	public static function instance()
	{
		static $inst;
		
		if($inst === null)
		{
			$inst = new SolutionTrainView();
		}
		return $inst;
	}

	public function displayHTML($st)
	{
		echo
		'<body>
			<div class="container-fluid buffer">
				<!-- Information (Employee) -->
				<div class="row">
					<div class="col-md-9">
						<table class="table table-condensed table-bordered">
							<tr>
								<thead colspan="!" ><h3>Information</h3></thead>
							</tr>
							<tr>
								<td style="width:200px;">Team ID</td>
								<td></td>
							</tr>
							<tr>
								<td>Agile Release Train (ART) Name</td>
								<td></td>
							</tr>
						</table>
					</div>
				</div>
				

				
				<!-- Team Members -->
				<div class="row">
					<div class="col-md-9">
						<table class="table table-condensed table-bordered">
							<tr>
								<thead colspan="3" ><h3>Team Members (*): </h3></thead>
							</tr>
							<tr>
								<th style="width:200px;">First Name</th>
								<th>Last Name</th>
								<th>Email</th>
								<th>Role</th>
								<th>Certifications</th>
								<th>Location</th>
							</tr>
							
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						</table>
					</div>
				</div>

				<!-- Team Members -->
				<div class="row">
					<div class="col-md-9">
						<table class="table table-condensed table-bordered">
							<tr>
								<thead colspan="3" ><h3>Participating Agile Release Trains (ARTs) (*):
</h3></thead>
							</tr>
							<tr>
								<th style="width:200px;">Team ID</th>
								<th>Team Name</th>
								<th>Release Train Engineer (RTE)
</th>
								<th>Product Owner (PO)
</th>
							</tr>
							
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						</table>
					</div>
				</div>

				<!-- SAFe Review Comments -->
		<div class="row">
			<div class="col-md-9">
				<table class="table table-condensed table-bordered">
					<tr>
						<thead colspan="2" ><h3>SAFe Review Comments:</h3></thead>
					</tr>
					<tr>
						<th style="width:200px;">Team Size</th>
						<td></td>
					</tr>
					<tr>
						<th>All Roles Filled</th>
						<td></td>
					</tr>
					<tr>
						<th>All Are Trained</th>
						<td></td>
					</tr>
					<tr>
						<th>Co-Located</th>
						<td></td>
					</tr>
				</table>
			</div>
		</div>

			</div>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/jquery.dataTables.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/dataTables.bootstrap.min.js"></script>
				
			<script type="text/javascript">
				$(document).ready(function () {
					$(\'#info\').DataTable();
				});
			</script>
		</body>';
	}
}

?>