<!DOCTYPE html>
<html>
<head>
    <title>Redirecting to Easebuzz...</title>
</head>
<body onload="document.forms['easebuzz_form'].submit()">
    <h3>Please wait, redirecting to Easebuzz...</h3>
    <form name="easebuzz_form" method="POST" action="{{ $payment_url }}">
        @foreach ($postData as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
        <noscript>
            <button type="submit">Click here if not redirected</button>
        </noscript>
    </form>
</body>
</html>
