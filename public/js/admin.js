function toggleEdit() {
    var editableCells = $("td.item-cell[contenteditable]");
    if (editableCells.length > 0) {
        $(".item-cell").removeAttr("contenteditable");
        $("#editBtn").html("Edit Items");
    } else {
        $(".item-cell").attr("contenteditable", "plaintext-only");
        $("#editBtn").html("Lock Items");
    }
        
}

function deleteRow(element) {
    $(element).parent().parent().remove();
}

function addRow() {
    // Input values
    var newItemName = $("#new-score-item-name").val();
    var newItemDesc = $("#new-score-item-desc").val();
    var newItemGoal = $("#new-score-item-goal").val();
    var newItemWeight = $("#new-score-item-weight").val();

    var hasBlankInput = false;
    if (newItemName == "") hasBlankInput = true;
    if (newItemDesc == "") hasBlankInput = true;
    if (newItemGoal == "") hasBlankInput = true;
    if (newItemWeight == "") hasBlankInput = true;

    if (hasBlankInput == true) {
        alert("Please input value");
        return;
    }

    var newRow = document.createElement("tr");
    var newRowItem = document.createElement("td");
    var newRowDesc = document.createElement("td");
    var newRowGoal = document.createElement("td");
    var newRowWeight = document.createElement("td");
    var newRowAction = document.createElement("td");

    newRowItem.setAttribute("class", "item-cell");
    newRowDesc.setAttribute("class", "item-cell");
    newRowGoal.setAttribute("class", "item-cell");
    newRowWeight.setAttribute("class", "item-cell");

    if ($("#editBtn").html() == "Lock Items") {
        newRowItem.setAttribute("contenteditable", "plaintext-only");
        newRowDesc.setAttribute("contenteditable", "plaintext-only");
        newRowGoal.setAttribute("contenteditable", "plaintext-only");
        newRowWeight.setAttribute("contenteditable", "plaintext-only");
    }

    newRowItem.innerHTML = newItemName;
    newRowDesc.innerHTML = newItemDesc;
    newRowGoal.innerHTML = newItemGoal;
    newRowWeight.innerHTML = newItemWeight + '%';
    newRowAction.innerHTML = "<span class='btn btn-danger' onclick='deleteRow(this)'>Delete</span>";

    newRow.appendChild(newRowItem);
    newRow.appendChild(newRowDesc);
    newRow.appendChild(newRowGoal);
    newRow.appendChild(newRowWeight);
    newRow.appendChild(newRowAction);

    // Request the added item's id to server
    // To be added as tr's id for updating purpose
    // Format: score_card_item_id-score_card_item_name (1-Item), (1-Description)
    request("save-score-item", {
        newItem: newItemName,
        newDesc: newItemDesc,
        newGoal: newItemGoal,
        newWeight: newItemWeight,
    }, function() {
        if (this.readyState == 4 && this.status == 200) {
            var newRowId = parseInt(this.responseText) + 1;
            newRowItem.id = newRowId + "-Name";
            newRowDesc.id = newRowId + "-Description";
            newRowGoal.id = newRowId + "-Goal";
            newRowWeight.id = newRowId + "-Weight";
            var nr = document.getElementById("new-row");
            nr.parentElement.insertBefore(newRow, nr);
        }
    });

    $("#new-score-item-name").val("");
    $("#new-score-item-desc").val("");
    $("#new-score-item-goal").val("");
    $("#new-score-item-weight").val("");
}