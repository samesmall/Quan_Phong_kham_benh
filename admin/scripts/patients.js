
let add_patients_form = document.getElementById('add_patients_form');

add_patients_form.addEventListener('submit', function(e) {
    e.preventDefault();
    add_patients();
});

function add_patients() {
    let data = new FormData();
    data.append('add_patients', '');
    data.append('Patients_name', add_patients_form.elements["Patients_name"].value);
    data.append('date_of_birth', add_patients_form.elements["date_of_birth"].value);
    data.append('gender', add_patients_form.elements["gender"].value);
    data.append('address', add_patients_form.elements["address"].value);
    data.append('number', add_patients_form.elements["number"].value);
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/patients.php", true);
    xhr.onload = function() {
        var myModal = document.getElementById("add-patients");
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();
        if (this.responseText == 1) {
            alert("success", "New patient added!");
            add_patients_form.elements["Patients_name"].value = '';
            add_patients_form.elements["date_of_birth"].value = '';
            add_patients_form.elements["gender"].value = '';
            add_patients_form.elements["address"].value = '';
            add_patients_form.elements["number"].value = '';
            get_all_patients();
        } else {
            alert("error", "Server Down!");
        }
    };
    xhr.send(data);
}

function get_all_patients() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/patients.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        document.getElementById('patients-data').innerHTML = this.responseText;
    };
    xhr.send('get_all_patients');
}

function submit_edit_patients() {
    let data = new FormData();
    data.append('edit_patients', '');
    data.append('patients_id', edit_patients_form.elements["patients_id"].value);
    data.append('Patients_name', edit_patients_form.elements["Patients_name"].value);
    data.append('date_of_birth', edit_patients_form.elements["date_of_birth"].value);
    data.append('gender', edit_patients_form.elements["gender"].value);
    data.append('address', edit_patients_form.elements["address"].value);
    data.append('number', edit_patients_form.elements["number"].value);
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/patients.php", true);
    xhr.onload = function() {
        console.log(this.responseText);
        var myModal = document.getElementById("edit-patients");
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();
        if (this.responseText == 1) {
            alert('success', 'Patients data edited!');
            edit_patients_form.reset();
            get_all_patients();
        } else {
            alert('error', 'Server Down!');
        }
    }
    xhr.send(data);
}

function toggle_status(id, val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/patients.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (this.responseText == 1) {
            alert('success', 'Status toggled!');
            get_all_patients();
        } else {
            alert('success', 'Server Down!');
        }
    }
    xhr.send('toggle_status=' + id + '&value=' + val);
}

let edit_patients_form = document.getElementById('edit_patients_form');

function edit_details(id) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/patients.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        let data = JSON.parse(this.responseText);
        edit_patients_form.elements["patients_id"].value = data.patientdata.patients_id;
        edit_patients_form.elements["Patients_name"].value = data.patientdata.Patients_name;
        edit_patients_form.elements["date_of_birth"].value = data.patientdata.date_of_birth;
        edit_patients_form.elements["gender"].value = data.patientdata.gender;
        edit_patients_form.elements["address"].value = data.patientdata.address;
        edit_patients_form.elements["number"].value = data.patientdata.number;
    }
    xhr.send('get_patients='+id);
}

edit_patients_form.addEventListener('submit', function(e) {
    e.preventDefault();
    submit_edit_patients();
});






function remove_patients(id)
{
    if(confirm("Are you sure, you want to delete this patients?"))
    {
    let data = new FormData();
    data.append('patients_id',id);
    data.append('remove_patients','');
    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/patients.php",true);
    xhr.onload = function() 
    {
        console.log(this.responseText);
        if (this.responseText == 1) {
            alert('success','Patients Removed!');
            get_all_patients();
        } 
        else{
            alert('error','Patients Removal failed!');      
        }
    }
    xhr.send(data);
    }
}

window.onload = function() {
    get_all_patients();
}
