<div class="card shadow-sm h-100">
    <div class="card-body">

        <h5 class="{{ $type === 'KEEP' ? 'text-success' : 'text-danger' }}">
            {{ $type }} PATIENT
            @if($type === 'KEEP')
                <small class="text-muted">(Editable)</small>
            @endif
        </h5>

        {{-- Name --}}
        <div class="mb-2">
            <strong>First Name:</strong>
            @if($type === 'KEEP')
                <input type="text"
                       class="form-control form-control-sm keep-input"
                       data-field="fname"
                       value="{{ $patient->fname }}">
            @else
                {{ $patient->fname }}
            @endif
        </div>
          <div class="mb-2">
            <strong>Last Name:</strong>
            @if($type === 'KEEP')
                <input type="text"
                       class="form-control form-control-sm keep-input"
                       data-field="lname"
                       value="{{ $patient->lname }}">
            @else
                {{ $patient->lname }}
            @endif
        </div>

        {{-- Email --}}
        <div class="mb-2">
            <strong>Email:</strong>
            @if($type === 'KEEP')
                <input type="email"
                       class="form-control form-control-sm keep-input"
                       data-field="email"
                       value="{{ $patient->email }}">
            @else
                {{ $patient->email }}
            @endif
        </div>

        {{-- Phone --}}
        <div class="mb-2">
            <strong>Phone:</strong>
            @if($type === 'KEEP')
                <input type="text"
                       class="form-control form-control-sm keep-input"
                       data-field="phone"
                       value="{{ $patient->phone }}">
            @else
                {{ $patient->phone }}
            @endif
        </div>

        <p><strong>Login ID:</strong> {{ $patient->patient_login_id }}</p>

        <hr>

        <p><strong>Transactions:</strong> {{ $patient->transaction_count }}</p>
        <p><strong>Services:</strong> {{ $patient->service_count }}</p>

        <p><strong>Self Giftcards:</strong> {{ $patient->self_giftcard_count }}</p>
        <p><strong>Giftcards to Others:</strong> {{ $patient->other_giftcard_count }}</p>

    </div>
</div>
