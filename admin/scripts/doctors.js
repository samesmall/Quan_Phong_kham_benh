
let add_doctors_form = document.getElementById('add_doctors_form');

add_doctors_form.addEventListener('submit', function(e) {
    e.preventDefault();
    add_doctors();
});

function add_doctors() {
    let data = new FormData();
    data.append('add_doctors', '');
    data.append('Doctor_name', add_doctors_form.elements["Doctor_name"].value);
    data.append('Specialized', add_doctors_form.elements["Specialized"].value);
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/doctors.php", true);
    xhr.onload = function() {
        var myModal = document.getElementById("add-doctors");
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();
        if (this.responseText == 1) {
            alert("success", "New doctor added!");
            add_doctors_form.elements["Doctor_name"].value = '';
            add_doctors_form.elements["Specialized"].value = '';
            get_all_doctors();
        } else {
            alert("error", "Server Down!");
        }
    };
    xhr.send(data);
}

function get_all_doctors() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/doctors.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        document.getElementById('doctors-data').innerHTML = this.responseText;
    };
    xhr.send('get_all_doctors');
}

function submit_edit_doctors() {
    let data = new FormData();
    data.append('edit_doctors', '');
    data.append('Doctor_id', edit_doctors_form.elements["Doctor_id"].value);
    data.append('Doctor_name', edit_doctors_form.elements["Doctor_name"].value);
    data.append('Specialized', edit_doctors_form.elements["Specialized"].value);
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/doctors.php", true);
    xhr.onload = function() {

        var myModal = document.getElementById("edit-doctors");
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();
        if (this.responseText == 1) {
            alert('success', 'Doctor data edited!');
            edit_doctors_form.reset();
            get_all_doctors();
        } else {
            alert('error', 'Server Down!');
        }
    }
    xhr.send(data);
}

function toggle_status(id, val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/doctors.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (this.responseText == 1) {
            alert('success', 'Status toggled!');
            get_all_doctors();
        } else {
            alert('success', 'Server Down!');
        }
    }
    xhr.send('toggle_status=' + id + '&value=' + val);
}

let edit_doctors_form = document.getElementById('edit_doctors_form');

function edit_doctors(id) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/doctors.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        let data = JSON.parse(this.responseText);
        alert(data);
        edit_doctors_form.elements['Doctor_id'].value = data.doctordata.Doctor_id;
        edit_doctors_form.elements['Doctor_name'].value = data.doctordata.Doctor_name;
        edit_doctors_form.elements['Specialized'].value = data.doctordata.Specialized;
    }
    xhr.send('get_doctors='+id);
}

edit_doctors_form.addEventListener('submit', function(e) {
    e.preventDefault();
    submit_edit_doctors();
});






function remove_doctors(id)
{
    if(confirm("Are you sure, you want to delete this doctor?"))
    {
    let data = new FormData();
    data.append('Doctor_id',id);
    data.append('remove_doctors','');
    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/doctors.php",true);
    xhr.onload = function() 
    {
        console.log(this.responseText);
        if (this.responseText == 1) {
            alert('success','Doctors Removed!');
            get_all_doctors();
        } 
        else{
            alert('error','Doctors Removal failed!');      
        }
    }
    xhr.send(data);
    }
}

window.onload = function() {
    get_all_doctors();
}
