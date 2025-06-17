@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-bold text-primary mb-6">🛒 Your Cart</h1>

    @if(session('success'))
    <div class="mb-4 flex items-center bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded" role="alert">
        <svg class="w-5 h-5 mr-2 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path d="M10 15a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm0-11a1.5 1.5 0 110 3 1.5 1.5 0 010-3z"/>
        </svg>
        <span>{{ session('success') }}</span>
    </div>
@endif

@if(session('error'))
    <div class="mb-4 flex items-center bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded" role="alert">
        <svg class="w-5 h-5 mr-2 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path d="M10 15a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm0-11a1.5 1.5 0 110 3 1.5 1.5 0 010-3z"/>
        </svg>
        <span>{{ session('error') }}</span>
    </div>
@endif


    @if($cart->items->count())
        <table class="w-full table-auto mb-6 bg-white shadow-md rounded-lg">
            <thead class="bg-primary text-white">
                <tr>
                    <th class="p-3">Product</th>
                    <th class="p-3">Price</th>
                    <th class="p-3">Quantity</th>
                    <th class="p-3">Total</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($cart->items as $item)
                    @php
                        $subtotal = $item->quantity * $item->product->discount_price;
                        $total += $subtotal;
                    @endphp
                    <tr class="border-b">
                        <td class="p-3">{{ $item->product->name }}</td>
                        <td class="p-3">{{ number_format($item->product->discount_price, 2) }}DH</td>
                        <td class="p-3">{{ $item->quantity }}</td>
                        <td class="p-3">{{ number_format($subtotal, 2) }}DH</td>
                        <td class="p-3">
                            <form action="{{ route('cart.remove', $item) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-right mb-6">
            <p class="text-xl font-semibold">Total: {{ number_format($total, 2) }}DH</p>
        </div>

        <form id="payment-form" action="{{ route('payment') }}" method="POST" class="text-right">
    @csrf
    <input type="hidden" name="amount" value="{{ intval($total * 100) }}"> {{-- en cents --}}
    <div id="card-element" class="mb-4"></div>
    <div id="card-errors" class="text-red-600 mb-4" role="alert"></div>
    <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded text-lg font-semibold">
        Pay by Card
    </button>
</form>
<form action="{{ route('payment.cash') }}" method="POST" class="text-right mt-4">
    @csrf
    <input type="hidden" name="amount" value="{{ intval($total * 100) }}"> {{-- en cents --}}
    <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded text-lg font-semibold">
        Payer en espèces
    </button>
</form>

{{-- Stripe JS --}}
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe("{{ env('STRIPE_KEY') }}");
    const elements = stripe.elements();
    
    // Style personnalisé
    const style = {
        base: {
            color: '#374151',  // Couleur du texte (gray-700)
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#9CA3AF'  // Couleur du placeholder (gray-400)
            },
            backgroundColor: '#F3F4F6'  // Fond gris clair (gray-100)
        },
        invalid: {
            color: '#EF4444',  // Couleur erreur (red-500)
            iconColor: '#EF4444'
        }
    };

    // Appliquer le style
    const card = elements.create('card', {
        style: style,
        classes: {
            focus: 'border-primary shadow-outline',
            empty: 'bg-gray-100',
            invalid: 'border-red-500'
        }
    });

    card.mount('#card-element');
    const form = document.getElementById('payment-form');
form.addEventListener('submit', async function (event) {
    event.preventDefault();

    const { token, error } = await stripe.createToken(card);

    if (error) {
        document.getElementById('card-errors').textContent = error.message;
    } else {
        const hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);
        form.submit();
    }
});

</script>

    @else
        <p>Your cart is empty.</p>
    @endif
</div>
@endsection
