<?php
final class AgileReleaseTrainView
{

	private function AgileReleaseTrainView()
	{

	}

	public static function instance()
	{
		static $inst;
		
		if($inst === null)
		{
			$inst = new AgileReleaseTrainView();
		}
		return $inst;
	}

	public function displayHTML($art)
	{
		echo
		'<div class="container-fluid buffer">
		<!-- Information -->
		<div class="row">
			<div class="col-md-9">
				<table class="table table-condensed table-bordered">
					<tr>
						<thead colspan="2" ><h3>Information:</h3></thead>
					</tr>
					<tr>
						<th style="width:200px;">Team ID</th>
						<td></td>
					</tr>
					<tr>
						<th>Agile Release Train (ART) Name</th>
						<td></td>
					</tr>
					<tr>
						<th>On Solution Train</th>
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
						<thead colspan="3" ><h3>Participating Agile Teams (*): </h3></thead>
					</tr>
					<tr>
						<th style="width:200px;">Team ID</th>
						<th>Team Name</th>
						<th>Scrum Master</th>
						<th>Product Owner</th>
					</tr>
					
					<tr>
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
	</div>';
	}
}


?>