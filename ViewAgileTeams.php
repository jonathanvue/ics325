<?php
	class ViewAgileTeams
	{
		private $emp;
		private $something;

		public function __construct($emp)
		{
			$this->emp = $emp;

		}
	
		public function getEmployee()
		{
			return $emp;
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
									<thead colspan="!" ><h3>Employee</h3></thead>
								</tr>
								<tr>
									<td style="width:200px;">First Name</td>
									<td>'; echo $emp->getEmployeeNumber(); echo '</td>
								</tr>
								<tr>
									<td>Last Name</td>
									<td>'; echo $this->something; echo '</td>
								</tr>
								<tr>
									<td>Email</td>
									<td></td>
								</tr>
								<tr>
									<td>City</td>
									<td></td>
								</tr>
								<tr>
									<td>Country</td>
									<td></td>
								</tr>
								<tr>
									<td>Manager\'s Name</td>
									<td></td>
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
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Agile Release Train</td>
									<td></td>
									<td class="disabled"></td>
								</tr>
								<tr>
									<td>Solution Train</td>
									<td></td>
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
									<td></td>
								</tr>
								<tr>
									<td>Course Name</td>
									<td></td>
								</tr>
								<tr>
									<td>Course Code</td>
									<td></td>
								</tr>
								<tr>
									<td>Trainer</td>
									<td></td>
								</tr>
								<tr>
									<td>Dates</td>
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