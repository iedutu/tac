<div class="row">
	<div class="col-lg-12">
		<!--begin::Card-->
		<div class="card card-custom gutter-b">
			<div class="card-header flex-wrap border-0 pt-6 pb-0">
				<div class="card-title">
					<h3 class="card-label">Report generation
							<span class="d-block text-muted pt-2 font-size-sm">Please select the dates for your reports or simply accept the default 6month to date default interval..</span></h3>
				</div>
			</div>
			<form class="form" id="kt_rohel_reports_form" action="/api/generateExcel.php" method="post">
				<input type="hidden" name="_submitted" id="_submitted" value="yes"/>
                <input type="hidden" name="_page" id="_page" value="<?=$_GET['data']?>"/>
				<div class="card-body">
					<div class="form-group row">
						<div class="col-lg-4">
							<label>Start date:</label>
							<div class="input-group date mb-2">
                                <input type="text" class="form-control" value="<?=date(Utils::$PHP_DATE_FORMAT, time()-Utils::$REPORTS_PERIOD*24*60*60)?>" placeholder="Click to select a date." id="rohel_reports_start" name="rohel_reports_start"/>
								<div class="input-group-append">
                                               <span class="input-group-text">
                                               <i class="la la-calendar"></i>
                                               </span>
								</div>
							</div>
						</div>
						<div class="col-lg-4">
							<label>End date:</label>
							<div class="input-group date mb-2">
								<input type="text" class="form-control" value="<?=date(Utils::$PHP_DATE_FORMAT, time())?>" placeholder="Click to select a date." id="rohel_reports_end" name="rohel_reports_end"/>
								<div class="input-group-append">
                                               <span class="input-group-text">
                                               <i class="la la-calendar"></i>
                                               </span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer">
					<div class="row">
						<div class="col-lg-8">
							<button type="submit" class="btn btn-primary mr-2" id="kt_reports_submit_btn">Submit</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
