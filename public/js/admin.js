function saveItems() {

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
    var newRowId = document.createElement("td");
    var newRowItem = document.createElement("td");
    var newRowDesc = document.createElement("td");
    var newRowGoal = document.createElement("td");
    var newRowWeight = document.createElement("td");
    var newRowAction = document.createElement("td");

    newRowItem.innerHTML = newItemName;
    newRowDesc.innerHTML = newItemDesc;
    newRowGoal.innerHTML = newItemGoal;
    newRowWeight.innerHTML = newItemWeight + '%';
    newRowAction.innerHTML = "<span class='btn btn-danger' onclick='deleteRow(this)'>Delete</span>";

    newRow.appendChild(newRowId);
    newRow.appendChild(newRowItem);
    newRow.appendChild(newRowDesc);
    newRow.appendChild(newRowGoal);
    newRow.appendChild(newRowWeight);
    newRow.appendChild(newRowAction);

    var nr = document.getElementsByClassName("new-row")[0];
    nr.parentElement.insertBefore(newRow, nr);

    $("#new-score-item-name").val("");
    $("#new-score-item-desc").val("");
    $("#new-score-item-goal").val("");
    $("#new-score-item-weight").val("");
}