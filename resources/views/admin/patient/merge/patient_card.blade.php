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
        <h5 class="text-primary">Services Details</h5>
        <p><strong>Transactions:</strong> {{ $patient->transaction_count }}</p>
        <p><strong>Services:</strong> {{ $patient->service_count }}</p>

        <hr>
        <h5 class="text-primary">GiftCard Details</h5>
        <p><strong>Self Purchases/Received Giftcard :</strong> {{ $patient->self_giftcard_count }}</p>
        <p><strong>Giftcard Send to Other  :</strong> {{ $patient->other_giftcard_count }}</p>

    </div>
</div>
