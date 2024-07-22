@extends('layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')

<div>
<input title="Add Employee" type="button" class="btn btn-success" value="Add" style="margin-top: 5px;margin-left:5px!important;" id="btnShowEmployeeModal">
  <table id="employeeTable" class="table">
    <thead>
      <tr>
        <th>Name</th>
        <th>Contact No</th>
        <th>Department</th>
        <th>View</th>
        <th>Edit</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody id="employeeTablebody">

    </tbody>
  </table>


</div>


<!-- Save Modal -->
<div class="modal fade" id="employeeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Employee</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <input type="hidden" name="lblHidden" id="lblHidden">

        <form id="employeeForm">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="fName" class="form-label">First Name</label>
              <input type="text" class="form-control" id="fName" name="firstName" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="lName" class="form-label">Last Name</label>
              <input type="text" class="form-control" id="lName" name="lastName" required>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="contact" class="form-label">Contact Number</label>
              <input type="text" class="form-control" id="contact" name="contactNo" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="txtNic" class="form-label">NIC</label>
              <input type="text" class="form-control" id="txtNic" name="nic" required>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="cmbDepartment" class="form-label">Department</label>
              <select name="departmentId" id="cmbDepartment" class="form-select">

              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label for="email" class="form-label">Email Address</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="address" class="form-label">Address</label>
              <input type="text" class="form-control" id="txtAddress" name="address" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="gender" class="form-label">Gender</label>
              <select name="gender" id="cmbGender" class="form-select">
                <option value="1">Male</option>
                <option value="2">Female</option>
              </select>

            </div>

          </div>

          <div class="row">
            <div class="col-md-6 mb-6">
              <label for="dtJoiningDate" class="form-label">Joining Date</label>
              <input type="date" class="form-control" id="dtJoiningDate" name="joiningDate" required>
            </div>
            <div class="col-md-6 mb-6">
              <label for="dtJoiningDate" class="form-label">Role</label>
              <select name="role" id="cmbRole" class="form-select">
                <option value="Admin">Admin</option>
                <option value="HR Manager">HR Manager</option>
                <option value="Employee">Employee</option>
              </select>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnEmpModalClose">Close</button>
        <button type="button" class="btn btn-primary" id="btnSaveEmp">Save</button>
      </div>
    </div>
  </div>
</div>


<!-- End of the modal -->


<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Delete Confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="" id="lblEmpIdForDelete">
        <p>Are you sure?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" id="btnConfirmDelete">Delete</button>
        <button type="button" class="btn btn-success" data-bs-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>

 <!-- End of delete the delete modal -->
<script src="{{ asset('js/employee.js') }}" defer></script>

@endsection