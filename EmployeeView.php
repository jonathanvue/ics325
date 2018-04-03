<?php
final class EmployeeView
{
	private function __construct()
	{

	}

	public static function instance()
	{
		static $inst;
		
		if($inst === null)
		{
			$inst = new EmployeeView();
		}
		return $inst;
	}

//This is the HTML that will display the data of a set of tables for the Employee View
	public function displayHTML($emp)
	{
		echo
		'<body>
			<div class="container-fluid buffer">
				<!-- Employee -->
				<div class="row">
					<div class="col-md-9">
						<table class="table table-condensed table-bordered">
							<tr>
								<thead colspan="!" ><h3>Information:</h3></thead>
							</tr>
							<tr>
								<td style="width:200px;">First Name</td>
								<td>'; echo $emp->getFirstName(); echo '</td>
							</tr>
							<tr>
								<td>Last Name</td>
								<td>'; echo $emp->getLastName(); echo '</td>
							</tr>
							<tr>
								<td>Email</td>
								<td>'; echo $emp->getEmailAddress(); echo '</td>
							</tr>
							<tr>
								<td>City</td>
								<td>'; echo $emp->getCity(); echo '</td>
							</tr>
							<tr>
								<td>Country</td>
								<td>'; echo $emp->getCountry(); echo '</td>
							</tr>
							<tr>
								<td>Manager\'s Name</td>
								<td>'; echo $emp->getManagerName(); echo '</td>
							</tr>
						</table>
					</div>
				</div>
				
				<!-- Teams -->
				<div class="row">
					<div class="col-md-9">
						<table class="table table-condensed table-bordered">
							<tr>
								<thead colspan="3" ><h3>Teams</h3></thead>
							</tr>
							<tr>
								<th style="width:200px;">Team</th>
								<th>Team Name</th>
								<th>Role</th>
							</tr>
							
							<tr>
								<td>Agile Team</td>
								<td>'; echo $emp->getAtName(); echo '</td>
								<td>'; echo $emp->getArtName(); echo '</td>
							</tr>
							<tr>
								<td>Agile Release Train</td>
								<td>'; echo $emp->getArtName(); echo '</td>
								<td class="disabled"></td>
							</tr>
							<tr>
								<td>Solution Train</td>
								<td>'; echo $emp->getSTName(); echo'</td>
								<td></td>
							</tr>
						</table>
					</div>
				</div>
				
				<!-- Training -->
				<div class="row">
					<div class="col-md-9">
						<table class="table table-condensed table-bordered">
							<tr>
								<thead colspan="2"><h3>Training</h3></thead>
							</tr>
							<tr>
							<td style="width:200px;">Status</td>
							<td>'; echo $emp->getStatus(); echo'</td>
							</tr>
							<tr>
								<td>Course Name</td>
								<td>'; echo $emp->getCourseName(); echo'</td>
							</tr>
							<tr>
								<td>Course Code</td>
								<td>'; echo $emp->getCourseCode(); echo'</td>
							</tr>
							<tr>
								<td>Trainer</td>
								<td>'; echo $emp->getTrainer(); echo'</td>
							</tr>
							<tr>
								<td>Dates</td>
								<td>'; echo $emp->getDates(); echo'</td>
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