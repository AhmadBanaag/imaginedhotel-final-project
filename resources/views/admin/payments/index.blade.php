@extends('layouts.admin')
@section('page-subtitle', 'Payment verification')
@section('content')
<section class="bg-white rounded-xl p-6">
    <h1 class="text-xl font-bold mb-3">Payment verification</h1>
    <p>Verify a payment after checking the cash received or matching the wallet reference to the transaction.</p>
    @if (session('status')) <p role="status">{{ session('status') }}</p> @endif
    <div class="overflow-x-auto"><table class="w-full text-left text-sm">
        <thead><tr>@foreach (['Payment','Reservation','Method','Reference','Amount','Status','Action'] as $label)<th class="p-2">{{ $label }}</th>@endforeach</tr></thead>
        <tbody>@forelse ($payments as $payment)
            <tr class="border-t">
                <td class="p-2">#{{ $payment->id }}</td><td>{{ $payment->reservation->reservation_code }}</td>
                <td>{{ $payment->paymentMethod->name }}</td><td>{{ $payment->reference_number ?? '—' }}</td>
                <td>₱{{ number_format($payment->amount, 2) }}</td><td>{{ ucfirst($payment->status) }}</td>
                <td>@if ($payment->status === 'pending')
                    <form method="post" action="{{ route('admin.payments.verify', $payment) }}">
                        @csrf @method('PATCH')
                        <button class="rounded-lg bg-emerald-700 text-white px-3 py-2">Confirm payment received</button>
                    </form>
                @endif</td>
            </tr>
        @empty <tr><td colspan="7" class="p-4">No payments recorded.</td></tr> @endforelse</tbody>
    </table></div>
    {{ $payments->links() }}
</section>
@endsection
