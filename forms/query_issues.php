<div class="span3">
	<form class="form well">
	  <div class="control-group">
	    <label class="control-label" for="frm_issue_id">Id</label>
	    <div class="controls">
	      <input type="text" id="frm_id" placeholder="Id/Name" class="input-block-level">
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label" for="frm_region">Region</label>
	    <div class="controls">
	      <select id="frm_region" class="input-block-level">
	      </select>
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label" for="frm_district">District</label>
	    <div class="controls">
	      <select id="frm_district" class="input-block-level">
	      </select>
	    </div>
	  </div>
	  <div class="control-group">
	    <div class="controls">
	      <label class="checkbox">
	        <input type="checkbox" id="frm_mtn" class="input-block-level"> MTN
	      </label>
		  <label class="checkbox">
	        <input type="checkbox" id="frm_tigo" class="input-block-level"> Tigo
	      </label>
	      <label class="checkbox">
	        <input type="checkbox" id="frm_vodafone" class="input-block-level"> Vodafone
	      </label>
		  <label class="checkbox">
	        <input type="checkbox" id="frm_expresso" class="input-block-level"> Expresso
	      </label>
		  <label class="checkbox">
	        <input type="checkbox" id="frm_glo" class="input-block-level"> Glo
	      </label>
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label" for="frm_category">Category</label>
	    <div class="controls">
	      <select id="frm_category" class="input-block-level">
	      </select>
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label" for="frm_issue">Issue</label>
	    <div class="controls">
	      <select id="frm_issue" class="input-block-level">
	      </select>
	    </div>
	  </div>
	  <div class="control-group">
	    <div class="controls">
	     <button type="submit" class="btn btn-block btn-success">Search</button>
	    </div>
	  </div>
	</form>
</div>
<!-- results -->
<div class="span9">
	<h4>Query Results</h4>
	<table class="table table-bordered">
		<thead>
			<td>
				Id
			</td>
			<td>
				Name
			</td>
			<td>
				Region
			</td>
			<td>
				District
			</td>
			<td>
				Operator
			</td>
			<td>
				Actions
			</td>
		</thead>
	</table>
</div>