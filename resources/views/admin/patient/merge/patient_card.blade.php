<div class="card shadow-sm h-100">
    <div class="card-body">

        <h5 class="{{ $type === 'KEEP' ? 'text-success' : 'text-danger' }}">
            {{ $type }} PATIENT
        </h5>

        <p><strong>Name:</strong> {{ $patient->fname }} {{ $patient->lname }}</p>
        <p><strong>Email:</strong> {{ $patient->email }}</p>
        <p><strong>Phone:</strong> {{ $patient->phone }}</p>
        <p><strong>Login ID:</strong> {{ $patient->patient_login_id }}</p>

        <hr>

        <p><strong>Transactions:</strong> {{ $patient->transaction_count }}</p>
        <p><strong>Services:</strong> {{ $patient->service_count }}</p>

    </div>
</div>
