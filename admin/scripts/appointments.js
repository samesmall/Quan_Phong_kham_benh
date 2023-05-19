
let add_appointments_form = document.getElementById('add_appointments_form');

add_appointments_form.addEventListener('submit', function(e) {
    e.preventDefault();
    add_appointments();
});

function add_appointments() {
    let data = new FormData();
    data.append('add_appointments', '');
    data.append('doctors_id', add_appointments_form.elements["doctors_id"].value);
    data.append('patients_id', add_appointments_form.elements["patients_id"].value);
    data.append('Appointment_time', add_appointments_form.elements["Appointment_time"].value);
    data.append('note', add_appointments_form.elements["note"].value);
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/appointments.php", true);
    xhr.onload = function() {
        var myModal = document.getElementById("add-appointments");
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();
        if (this.responseText == 1) {
            alert("success", "New appointments added!");
            add_appointments_form.elements["doctors_id"].value = '';
            add_appointments_form.elements["patients_id"].value = '';
            add_appointments_form.elements["Appointment_time"].value = '';
            add_appointments_form.elements["note"].value = '';
            get_all_appointments();
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
    data.append('Appointment_id', edit_appointments_form.elements["Appointment_id"].value);
    data.append('doctors_id', edit_appointments_form.elements["doctors_id"].value);
    data.append('patients_id', edit_appointments_form.elements["patients_id"].value);
    data.append('Appointment_time', edit_appointments_form.elements["Appointment_time"].value);
    data.append('note', edit_appointments_form.elements["note"].value);
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/appointments.php", true);
    xhr.onload = function() {
        console.log(this.responseText);
        var myModal = document.getElementById("edit-appointments");
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();
        if (this.responseText == 1) {
            alert('success', 'Appointments data edited!');
            edit_appointments_form.reset();
            get_all_appointments();
        } else {
            alert('error', 'Server Down!');
        }
    }
    xhr.send(data);
}

function toggle_status(id, val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/appointments.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (this.responseText == 1) {
            alert('success', 'Status toggled!');
            get_all_appointments();
        } else {
            alert('success', 'Server Down!');
        }
    }
    xhr.send('toggle_status=' + id + '&value=' + val);
}

let edit_appointments_form = document.getElementById('edit_appointments_form');

function edit_appointments(id) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/appointments.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        let data = JSON.parse(this.responseText);
        alert(data);
        edit_appointments_form.elements["Appointment_id"].value = data.appointmentdata.Appointment_id;
        edit_appointments_form.elements["doctors_id"].value = data.appointmentdata.doctors_id;
        edit_appointments_form.elements["patients_id"].value = data.appointmentdata.patients_id;
        edit_appointments_form.elements["Appointment_time"].value = data.appointmentdata.Appointment_time;
        edit_appointments_form.elements["note"].value = data.appointmentdata.note;
        
    }
    xhr.send('get_appointments='+id);
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
