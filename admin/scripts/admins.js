
let add_admins_form = document.getElementById('add_admins_form');

add_admins_form.addEventListener('submit', function(e) {
    e.preventDefault();
    add_admins();
});

function add_admins() {
    let data = new FormData();
    data.append('add_admins', '');
    data.append('admin_name', add_admins_form.elements["admin_name"].value);
    data.append('admin_pass', add_admins_form.elements["admin_pass"].value);
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/admins.php", true);
    xhr.onload = function() {
        var myModal = document.getElementById("add-admins");
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();
        if (this.responseText == 1) {
            alert("success", "New admin added!");
            add_admins_form.reset();
        } else {
            alert("error", "Server Down!");
        }
    };
    xhr.send(data);
}

function get_all_admins() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/admins.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        document.getElementById('admins-data').innerHTML = this.responseText;
    };
    xhr.send('get_all_admins');
}



function toggle_status(id, val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/admins.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (this.responseText == 1) {
            alert('success', 'Status toggled!');
            get_all_admins();
        } else {
            alert('success', 'Server Down!');
        }
    }
    xhr.send('toggle_status=' + id + '&value=' + val);
}








function remove_admins(id)
{
    if(confirm("Are you sure, you want to delete this admins?"))
    {
    let data = new FormData();
    data.append('sr_no',id);
    data.append('remove_admins','');
    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/admins.php",true);
    xhr.onload = function() 
    {
        console.log(this.responseText);
        if (this.responseText == 1) {
            alert('success','Admins Removed!');
            get_all_admins();
        } 
        else{
            alert('error','Admins Removal failed!');      
        }
    }
    xhr.send(data);
    }
}

window.onload = function() {
    get_all_admins();
}
