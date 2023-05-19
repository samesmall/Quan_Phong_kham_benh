
let add_testresults_form = document.getElementById('add_testresults_form');

add_testresults_form.addEventListener('submit', function(e) {
    e.preventDefault();
    add_testresults();
});

function add_testresults() {
    let data = new FormData();
    data.append('add_testresults', '');
    data.append('patients_id', add_testresults_form.elements["patients_id"].value);
    data.append('type_of_result', add_testresults_form.elements["type_of_result"].value);
    data.append('result_description', add_testresults_form.elements["result_description"].value);
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/testresults.php", true);
    xhr.onload = function() {
        var myModal = document.getElementById("add-testresults");
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();
        if (this.responseText == 1) {
            alert("success", "New test results added!");
            add_testresults_form.elements["patients_id"].value = '';
            add_testresults_form.elements["type_of_result"].value = '';
            add_testresults_form.elements["result_description"].value = '';
            get_all_testresults();
        } else {
            alert("error", "Server Down!");
        }
    };
    xhr.send(data);
}

function get_all_testresults() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/testresults.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        document.getElementById('testresults-data').innerHTML = this.responseText;
    };
    xhr.send('get_all_testresults');
}

function submit_edit_testresults() {
    let data = new FormData();
    data.append('edit_testresults', '');
    data.append('type_of_result', add_testresults_form.elements["type_of_result"].value);
    data.append('result_description', add_testresults_form.elements["result_description"].value);
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/testresults.php", true);
    xhr.onload = function() {
        console.log(this.responseText);
        var myModal = document.getElementById("edit-testresults");
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();
        if (this.responseText == 1) {
            alert('success', 'Test results data edited!');
            edit_testresults_form.reset();
            get_all_testresults();
        } else {
            alert('error', 'Server Down!');
        }
    }
    xhr.send(data);
}

function toggle_status(id, val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/testresults.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (this.responseText == 1) {
            alert('success', 'Status toggled!');
            get_all_testresults();
        } else {
            alert('success', 'Server Down!');
        }
    }
    xhr.send('toggle_status=' + id + '&value=' + val);
}

let edit_testresults_form = document.getElementById('edit_testresults_form');

function edit_details(id) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/testresults.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        let data = JSON.parse(this.responseText);
        edit_testresults_form.elements['type_of_result'].value = data.testresultdata.type_of_result;
        edit_testresults_form.elements['result_description'].value = data.testresultdata.result_description;
    }
    xhr.send('get_testresults='+id);
}

edit_testresults_form.addEventListener('submit', function(e) {
    e.preventDefault();
    submit_edit_testresults();
});






function remove_testresults(id)
{
    if(confirm("Are you sure, you want to delete this test results?"))
    {
    let data = new FormData();
    data.append('result_id',id);
    data.append('remove_testresults','');
    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/testresults.php",true);
    xhr.onload = function() 
    {
        console.log(this.responseText);
        if (this.responseText == 1) {
            alert('success','Test results Removed!');
            get_all_testresults();
        } 
        else{
            alert('error','Test results Removal failed!');      
        }
    }
    xhr.send(data);
    }
}

window.onload = function() {
    get_all_testresults();
}




