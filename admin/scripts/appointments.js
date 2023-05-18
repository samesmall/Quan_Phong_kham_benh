
let add_appointments_form = document.getElementById('add_appointments_form');

add_appointments_form.addEventListener('submit', function(e) {
    e.preventDefault();
    add_appointments();
});

function add_appointments() {
    let data = new FormData();
    data.append('add_appointments', '');
    data.append('Patient_name', add_patients_form.elements["Patient_name"].value);
    data.append('date_of_birth', add_patients_form.elements["date_of_birth"].value);
    data.append('gender', add_patients_form.elements["gender"].value);
    data.append('address', add_patients_form.elements["address"].value);
    data.append('number', add_patients_form.elements["number"].value);
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/appointments.php", true);
    xhr.onload = function() {
        var myModal = document.getElementById("add-appointments");
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();
        if (this.responseText == 1) {
            alert("success", "New appointments added!");
            add_appointments_form.reset();
        } else {
            alert("error", "Server Down!");
        }
    };
    xhr.send(data);
}

function get_all_appointments() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/appointments.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        document.getElementById('appointments-data').innerHTML = this.responseText;
    };
    xhr.send('get_all_appointments');
}

function submit_edit_appointments() {
    let data = new FormData();
    data.append('edit_appointments', '');
    data.append('Patient_name', add_patients_form.elements["Patient_name"].value);
    data.append('date_of_birth', add_patients_form.elements["date_of_birth"].value);
    data.append('gender', add_patients_form.elements["gender"].value);
    data.append('address', add_patients_form.elements["address"].value);
    data.append('number', add_patients_form.elements["number"].value);
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/appointments.php", true);
    xhr.onload = function() {
        console.log(this.responseText);
        var myModal = document.getElementById("edit-appointments");
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();
        if (this.responseText == 1) {
            alert('success', 'Appointments data edited!');
            edit_patients_form.reset();
            get_all_appointments();
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

let edit_appointments_form = document.getElementById('edit_appointments_form');

function edit_details(id) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/appointments.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        let data = JSON.parse(this.responseText);
        alert(data);
        edit_doctors_form.elements['Doctor_name'].value = data.doctordata.Doctor_name;
        edit_doctors_form.elements['Specialized'].value = data.doctordata.Specialized;
    }
    xhr.send('get_doctors='+id);
}

edit_appointments_form.addEventListener('submit', function(e) {
    e.preventDefault();
    submit_edit_appointments();
});






function remove_appointments(id)
{
    if(confirm("Are you sure, you want to delete this appointments?"))
    {
    let data = new FormData();
    data.append('Appointment_id',id);
    data.append('remove_appointments','');
    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/appointments.php",true);
    xhr.onload = function() 
    {
        console.log(this.responseText);
        if (this.responseText == 1) {
            alert('success','Appointments Removed!');
            get_all_appointments();
        } 
        else{
            alert('error','Appointments Removal failed!');      
        }
    }
    xhr.send(data);
    }
}

window.onload = function() {
    get_all_appointments();
}
