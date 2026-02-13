<h2>{{ $employee->first_name }} {{ $employee->last_name }}</h2>
<p>Email: {{ $employee->email }}</p>
<p>Phone: {{ $employee->phone }}</p>
<p>Designation: {{ $employee->designation->name ?? '' }}</p>
<hr>
<h4>Attendance Records</h4>
@foreach($employee->attendance as $a)
    {{ $a->attendance_date }} - {{ $a->status }} <br>
@endforeach
