<div class="row-fluid">
    <div class="span12">
        <form class="form well">
            <div class="row-fluid">
                <div class="span4">
                    <label>Id/Name</label>
                    <input type="text" id="frm_id" placeholder="id/name">
                </div>
                <div class="span4">
                    <label>Region</label>
                    <select id="frm_region"></select>
                </div>
                <div class="span4">
                    <label>District</label>
                    <select id="frm_district"></select>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <label>Operator</label>
                    <label class="checkbox inline">
                        <input type="checkbox" id="frm_mtn" value="option1"> MTN
                    </label>
                    <label class="checkbox inline">
                        <input type="checkbox" id="frm_vodafone" value="option2"> Vodafone
                    </label>
                    <label class="checkbox inline">
                        <input type="checkbox" id="frm_airtel" value="option3"> Airtel
                    </label>
                    <label class="checkbox inline">
                        <input type="checkbox" id="frm_tigo" value="option2"> Tigo
                    </label>
                    <label class="checkbox inline">
                        <input type="checkbox" id="frm_expresso" value="option3"> Expresso
                    </label>
                </div>
            </div>
            <hr>
            <div class="row-fluid">
                <div class="span12">
                    <label>Category</label>
                    <select type="text" id="frm_category" class="input-block-level"></select>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <label>Issue</label>
                    <select type="text" id="frm_issue" class="input-block-level"></select>
                </div>
            </div>
            <hr>
            <div class="row-fluid">
                <div class="pull-right">
                <button class="btn btn-success">Search</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- results -->
<div class="row-fluid">
    <div class="span12">
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
</div>