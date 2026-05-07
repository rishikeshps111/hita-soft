<div style="width: 600px; padding: 20px; margin: auto; border:1px solid #ccc; border-radius:20px; font-family: sans-serif;">
    <div style="text-align: center; border-bottom: 1px solid #B73182; padding-bottom: 10px;">
        <a href="{{ route('home') }}">
            <img src="{{ $logo }}" alt="Logo" style="width: 90px;">
        </a>
    </div>

    <div style="padding: 20px; font-size: 16px; color: #333;">
        {!! $message_content !!}
    </div>

    <hr>

    <p style="font-size: 12px; color: #777;">
        If you would prefer not receiving our emails, please
        <a href="{{ $unsubscribe_url }}">click here</a> to unsubscribe.
    </p>

    <p style="font-size: 14px;">
        Thanks & Regards,<br>
        <strong><a href="{{ route('home') }}">{{ $site_name }}</a></strong>
    </p>
</div>
