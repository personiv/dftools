window.onload = function() {
    mergeColumn(0);
    mergeColumn(1);
    $("#scorecard").css("visibility", "visible");
}

function mergeColumn(columnIndex) {
    var cells = $("#scorecard tbody tr td:nth-child(" + (columnIndex + 1) + ")");
    var currentIndex = 0;

    function applyMergeUpTo(i) {
        $(cells[currentIndex]).attr("rowspan", i - currentIndex);
        for (var j = currentIndex + 1; j < i; j++) $(cells[j]).css("display", "none");
        currentIndex = i;
    }

    for (var i = 1; i < cells.length; i++) {
        var cell = $(cells[i]);
        if (cell.html() == $(cells[currentIndex]).html()) continue;
        else applyMergeUpTo(i);
    }
    applyMergeUpTo(cells.length);
}