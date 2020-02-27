var editing = false;
window.onload = function() {
    $(".item-cell").on("change", function() { updateRow(this); });
}

function toggleEdit() {
    var editableCells = $(".item-cell[disabled]");
    if (editableCells.length > 0) {
        editing = true;
        $(".item-cell").removeAttr("disabled");
        $("#editBtn").html("<i class='fa fa-edit'></i>Edit Items");
    } else {
        editing = false;
        $(".item-cell").attr("disabled", "disabled");
        $("#editBtn").html("<i class='fa fa-lock'></i>Lock Items");
    }
        
}

function addRow() {
    // Input values
    var newItemClass = $("#new-score-item-class").val();
    var newItemName = $("#new-score-item-name").val();
    var newItemDesc = $("#new-score-item-desc").val();
    var newItemGoal = $("#new-score-item-goal").val();
    var newItemWeight = $("#new-score-item-weight").val();
    var newItemTitle = $("#new-score-item-title").val();
    var newItemCell = $("#new-score-item-cell").val();

    var hasBlankInput = false;
    if (newItemClass == "") hasBlankInput = true;
    if (newItemName == "") hasBlankInput = true;
    if (newItemDesc == "") hasBlankInput = true;
    if (newItemGoal == "") hasBlankInput = true;
    if (newItemWeight == "") hasBlankInput = true;
    if (newItemTitle == "") hasBlankInput = true;
    if (newItemCell == "") hasBlankInput = true;

    if (hasBlankInput == true) {
        alert("Please input value");
        return;
    }
    
    // Request the added item's id to server
    // To be added as tr's id for updating purpose
    // Format: score_card_item_id-score_card_item_name (1-Item), (1-Description)
    request("save-score-item", JSON.stringify({
        role: $("#item-role").val(),
        class: newItemClass,
        name: newItemName,
        description: newItemDesc,
        goal: newItemGoal,
        weight: newItemWeight,
        title: newItemTitle,
        cell: newItemCell
    }), function() {
        if (this.readyState == 4 && this.status == 200) {
            var newRowId = this.responseText;
            var newRowClassId = newRowId + "-score_item_class";
            var newRowItemId = newRowId + "-score_item_name";
            var newRowDescId = newRowId + "-score_item_desc";
            var newRowGoalId = newRowId + "-score_item_goal";
            var newRowWeightId = newRowId + "-score_item_weight";
            var newRowTitleId = newRowId + "-score_item_title";
            var newRowCellId = newRowId + "-score_item_cell";

            var isDisabled = "";
            if (!editing) isDisabled = "disabled";
            
            $("<tr><td><input id='" + newRowClassId + "' " + isDisabled + " type='text' class='form-control item-cell' value='" + newItemClass + "'></td><td><input id='" + newRowItemId + "' " + isDisabled + " type='text' class='form-control item-cell' value='" + newItemName + "'></td><td><textarea id='" + newRowDescId + "' " + isDisabled + " class='form-control item-cell'>" + newItemDesc + "</textarea></td><td><input id='" + newRowGoalId + "' " + isDisabled + " type='text' class='form-control item-cell' value='" + newItemGoal + "'></td><td><input id='" + newRowWeightId + "' " + isDisabled + " type='number' class='form-control item-cell' value='" + newItemWeight + "' min='0' max='100'></td><td><input id='" + newRowTitleId + "' " + isDisabled + " type='text' class='form-control item-cell' value='" + newItemTitle + "'></td><td><input id='" + newRowCellId + "' " + isDisabled + " type='text' class='form-control item-cell' value='" + newItemCell + "'></td><td><span class='btn btn-danger' onclick='deleteRow(this)'><i class='fa fa-trash'></i>Delete</span></td></tr>").insertBefore("#new-row").on("change", "*.item-cell", function() { updateRow(this); });
        }
    });

    $("#new-score-item-class").val("");
    $("#new-score-item-name").val("");
    $("#new-score-item-desc").val("");
    $("#new-score-item-goal").val("");
    $("#new-score-item-weight").val("");
    $("#new-score-item-title").val("");
    $("#new-score-item-cell").val("");
}

function updateRow(row) {
    var tokens = $(row).parent()[0].children[0].id.split('-');
    var uid = tokens[0];
    var ucolumn = tokens[1];
    var uvalue = $(row).parent()[0].children[0].value;
    request("update-score-item", JSON.stringify({ id: uid, column: ucolumn, value: uvalue }), null);
}

function deleteRow(element) {
    request("delete-score-item", JSON.stringify({
        id: $(element).parent().parent()[0].children[0].children[0].id.split('-')[0]
    }), function() {
        if (this.readyState == 4 && this.status == 200) {
            $(element).parent().parent().remove();
        }
    });
}