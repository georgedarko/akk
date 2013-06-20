<div class="span12 well">
	<h4>New Cell Site</h4>
	<form class="form-horizontal">
	  <div class="control-group">
	    <label class="control-label" for="frm_id">Id</label>
	    <div class="controls">
	      <input type="text" id="frm_id" placeholder="Id">
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label" for="frm_name">Name</label>
	    <div class="controls">
	      <input type="text" id="frm_name" placeholder="Name">
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label" for="frm_region">Region</label>
	    <div class="controls">
	      <select id="frm_region"></select>
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label" for="frm_district">District</label>
	    <div class="controls">
	      <select id="frm_district"></select>
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
	<div class="well">
	  <!-- all the issues go here, to add an issue copy the entire div below and repeat it, then modify the contents -->
	  <div class="control-group">
		<p class="lead"><i class="icon-exclamation-sign"></i> Issue Category</p>
	    <label class="control-label" for="frm_district">Locked and Well Fenced:</label>
	    <div class="controls">
	      	  <label class="checkbox">
		      	<input type="checkbox" id="frm_mtn" class="input-block-level"> Yes
		      </label>
		      <label class="checkbox">
		      	<input type="checkbox" id="frm_mtn" class="input-block-level"> No
		      </label>
	    </div>
	  </div>
	</div>
	<div class="control-group">
	    <div class="controls">
	      <button type="submit" id="btn_save" class="btn btn-success">Save</button>
	    </div>
	  </div>
	</form>
</div>