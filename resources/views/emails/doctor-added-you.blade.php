<p>Hello,</p>
<p>{{ $doctor->full_name }} added you as a patient on OrthoTransfer.</p>
<p>
@auth
<a href="{{ route('dashboard') }}">View your dashboard</a> to accept or reject this doctor and see documents.
@else
<a href="{{ route('register.patient.form') }}">Create your account</a> to view this doctor and documents.
@endauth
</p>

