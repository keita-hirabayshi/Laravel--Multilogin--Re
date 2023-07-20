<p>決済ページへリダイレクトします。</p>
<script src="https://js.stripe.com/v3/"></script>
<script>
    const publicKey = '{{ $publicKey }}'
    const stripe = Stripe(publicKey)
    
    window.onload = function() {
    stripe.redirectToCheckout({
    sessionId: '{{ $session->id }}'
    }).then(function (result) {
    // もしエラーが発生した場合には、cancel処理を行う
    window.location.href = '{{ route('user.cart.cancel') }}';
    });
    }
</script>