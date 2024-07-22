var messageBox = new MessageBox();
$(document).ready(function () {
    //Initialaizing data table
    $('#employeeTable').DataTable({

        columns: [

            { data: 'name' },
            { data: 'contactNo' },
            { data: 'department' },
            { data: 'view' },
            { data: 'edit' },
            { data: 'delete' }
        ]
    });

    //Show employee modal
    $('#btnShowEmployeeModal').on('click', function () {
        $('#employeeModal').modal('show');
        disableEnableFormComponents('add');

    });

    $('#employeeModal').on('show.bs.modal', function () {
        //Load deprtments to the model select tag
        loadDepartment();
    });

    //Load employees to the table
    loadEmployees();

    $('#btnSaveEmp').on('click', function () {
        if ($(this).text() == "Save") {
            saveEmployee();
        } else {
            updateEmployee();
        }
    });

    //Reset form on modal hide
    $('#employeeModal').on('hide.bs.modal', function () {
        $('#employeeForm')[0].reset();
    });

    //Delete employee
    $('#btnConfirmDelete').on('click',function(){
        var deleteEmpId = $('#lblEmpIdForDelete').val();
        deleteEmployee(deleteEmpId);
    })


});
//Load department to the select box
function loadDepartment() {
    $('#cmbDepartment').empty();
    $.ajax({
        url: '/loadDepartment',
        type: 'get',
        success: function (response) {
            $.each(response, function (index, value) {

                $('#cmbDepartment').append('<option value="' + value.departmentId + '">' + value.departmentName + '</option>');
            });

        }, error: function (data) {
            console.error(data);
        }

    })
}


//Save employee
function saveEmployee() {
    try {
        var form = $('#employeeForm')[0]; // Geting form element
        var formData = new FormData(form); //Appending form elemnts to the form data
        $.ajax({
            url: '/saveEmployee',
            type: 'post',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {

                if (response.status) {
                    messageBox.createMessage("Successfully saved", 'success');
                    $('#employeeForm')[0].reset();
                    $('#employeeModal').modal('hide');
                    loadEmployees();
                } else {
                    messageBox.createMessage("Unable  to  save", 'warning');
                }


            },
            error: function (xhr) {
                // Handle error
                console.error('Error saving employee:', xhr);
            }
        });

    } catch (ex) {
        console.error(ex);
        return ex;
    }
}
//Encode empId
function encodeId(empId) {
    return btoa(empId.toString());
}

//Update employee
function updateEmployee() {
    var empId = encodeId($('#lblHidden').val());
    try {
        var serializedData = $('#employeeForm').serialize();
        $.ajax({
            url: '/updateEmployee/' + empId,
            type: 'put',
            data: serializedData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {

                if (response.status) {
                    messageBox.createMessage("Successfully updated", 'success');
                    $('#employeeForm')[0].reset();
                    $('#employeeModal').modal('hide');
                    loadEmployees();
                } else {
                    messageBox.createMessage("Unable  to  update", 'warning');
                }


            },
            error: function (xhr) {
                // Handle error
                console.error('Error saving employee:', xhr);
            }
        });

    } catch (ex) {
        console.error(ex);
        return ex;
    }
}
//Load employees to the table
function loadEmployees() {
    try {
        $.ajax({
            url: '/loadEmployees',
            type: 'get',
            async: false,
            success: function (response) {
                console.log(response);
                var data = [];
                $.each(response.data, function (index, value) {
                    var btnView = "<button title='View' class='btn btn-success' onclick='showModalForViewOrEdit(" + value.employeeId + ", \"view\")'><i class='fa fa-eye'></i></button>";
                    var btnEdit = "<button title='Edit' class='btn btn-warning' onclick='showModalForViewOrEdit(" + value.employeeId + ",\"edit\")'><i class='fa fa-pencil'></i></button>";
                    var btnDelete = "<button title='Delete' class='btn btn-danger' onclick='showDeleteConfirmation(" + value.employeeId + ")'><i class='fa fa-trash'></i></button>";
                    data.push({
                        "name": value.name,
                        "contactNo": value.contactNo,
                        "department": value.departmentName,
                        "view": btnView,
                        "edit": btnEdit,
                        "delete": btnDelete
                    });

                    //Adding data to the data table
                    var table = $('#employeeTable').DataTable();
                    table.clear();
                    table.rows.add(data).draw();


                });
            }, error: function (response) {
                console.error(response);
            }
        })
    } catch (ex) {
        console.error(ex);
        return ex;
    }
}

//Show modal view or edit
function showModalForViewOrEdit(id, type) {
    $('#employeeModal').modal('show');
    disableEnableFormComponents(type);
    getEmployee(id);
}

//Show employee details on view and edit. In view mode, 'Save/Update' button would be disabled. 
function getEmployee(id) {
    $('#lblHidden').val(id);
    $.ajax({
        url: '/getEmployee/',
        type: 'get',
        data: {
            empId: id
        },
        async: false,
        success: function (response) {
            if (response.data) {
                var employeeData = response.data;
                for (var key in employeeData) {
                    console.log(key);
                    if (employeeData.hasOwnProperty(key)) {

                        $(`[name="${key}"]`).val(employeeData[key]);
                    }
                }
            }
        }, error: function (response) {
            console.error(response);
        }
    });
}

//Disable and enable form components
function disableEnableFormComponents(type) {
    if (type == "view") {
        $('#employeeForm').find('input, textarea, select').prop('disabled', true);
        $('#btnSaveEmp').hide();
    } else if (type == "edit") {
        $('#employeeForm').find('input, textarea, select').prop('disabled', false);
        $('#btnSaveEmp').show().text("Update");

    } else {
        $('#employeeForm').find('input, textarea, select').prop('disabled', false);
        $('#btnSaveEmp').show().text("Save");
    }

}

//Show delete confirmation modal
function showDeleteConfirmation(id) {
    $('#deleteModal').modal('show');
    $('#lblEmpIdForDelete').val(id)
}

function deleteEmployee(id) {
    var empId = encodeId(id);
    $.ajax({
        url: '/deleteEmployee/' + empId,
        type: 'delete',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.status) {
                $('#deleteModal').modal('hide');
                loadEmployees();
                messageBox.createMessage("Record deleted Successfully", 'success');
            }else{
                messageBox.createMessage("Unable  to  delete", 'warning');
            }
        },error:function(data){
            console.error(data);
        }

    })
}