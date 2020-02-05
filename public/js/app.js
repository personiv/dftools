function request(action, postData, success) {
    var r = new XMLHttpRequest();
    r.open("POST", action);
    r.setRequestHeader("Content-Type", "application/json");
    r.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
    r.onreadystatechange = success;
    requestObject = r;
    r.send(postData);
}