@extends('layouts.admin_layout')

@section('body')
<div class="container-fluid">

    <h3 class="mb-3">Access Control (Role Permissions)</h3>

    {{-- ROLE SELECT --}}
    <div class="card mb-3">
        <div class="card-body">
            <label>Select Role</label>
            <select id="role_id" class="form-control">
                <option value="">Select Role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- PERMISSIONS TABLE --}}
    <div class="card">
        <div class="card-body">

            <form id="permissionForm">
                @csrf
                <input type="hidden" name="role_id" id="hidden_role_id">

                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>Module Name</th>
                            <th>View</th>
                            <th>Create</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>

                        @php
                            $modules = [
                            'service_orders' => 'Service Orders',
                            'giftcard_orders' => 'Giftcard Orders',
                            'patient' => 'Patient',
                            'user' => 'User',
                            'employee' => 'Employee',
                            'category' => 'Category',
                            'product' => 'Product',
                            'services' => 'Services',
                            'giftcard_redeem' => 'GiftCard Redeem',
                            'service_redeem' => 'Service Redeem',
                            'terms_and_conditions' => 'Terms & Conditions',
                            'gift_card_coupons' => 'GiftCard Coupons',
                            'email_templates' => 'Email Templates',
                            'static_content' => 'Static Content',
                            'sliders' => 'Sliders',
                            'programs' => 'Programs',
                        ];
                        @endphp

                        @foreach($modules as $key => $label)
                        <tr>
                            <td>{{ $label }}</td>

                            @foreach(['view','create','edit','delete'] as $action)
                            <td>
                                <label class="switch">
                                    <input type="checkbox"
                                           name="permissions[]"
                                           value="{{ $action }}_{{ $key }}">
                                    <span class="slider"></span>
                                </label>
                            </td>
                            @endforeach

                        </tr>
                        @endforeach

                    </tbody>
                </table>

                <button type="button" class="btn btn-primary mt-3" onclick="savePermissions()">
                    Save Permissions
                </button>

            </form>

        </div>
    </div>

</div>
@endsection

{{-- ✅ TOGGLE CSS --}}
<style>
.switch {
  position: relative;
  display: inline-block;
  width: 40px;
  height: 20px;
}
.switch input { display: none; }

.slider {
  position: absolute;
  cursor: pointer;
  background-color: #ccc;
  border-radius: 20px;
  top: 0; left: 0; right: 0; bottom: 0;
  transition: 0.4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 14px;
  width: 14px;
  left: 3px;
  bottom: 3px;
  background: white;
  border-radius: 50%;
  transition: 0.4s;
}

input:checked + .slider {
  background-color: #28a745;
}

input:checked + .slider:before {
  transform: translateX(20px);
}
</style>

@push('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

// ✅ LOAD PERMISSIONS
$('#role_id').change(function () {

    let roleId = $(this).val();
    $('#hidden_role_id').val(roleId);

    if (!roleId) return;

    $.get("{{ url('admin/access-control/get') }}/" + roleId, function (data) {

        console.log(data); // 🔍 debug

        // Uncheck all
        $('input[type=checkbox]').prop('checked', false);

        if (!data || data.length === 0) return;

        data.forEach(function (perm) {
            $('input[type="checkbox"][value="' + perm + '"]').prop('checked', true);
        });

    });

});


// ✅ SAVE PERMISSIONS
function savePermissions() {

    let formData = $('#permissionForm').serialize();

    if(!$('#hidden_role_id').val()){
        Swal.fire({
            icon: 'warning',
            title: 'Please select role first'
        });
        return;
    }

    $.ajax({
        url: "{{ url('admin/access-control/store') }}",
        method: "POST",
        data: formData,
        success: function (response) {

            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: response.message,
                showConfirmButton: false,
                timer: 3000
            });

        }
    });
}

</script>
@endpush