<h2>New vehicle inquiry</h2>
<p><strong>Listing:</strong> {{ $vehicle->title }}</p>
<p><strong>From:</strong> {{ $senderName }} &lt;{{ $senderEmail }}&gt;</p>
<p><strong>Message:</strong></p>
<p>{!! nl2br(e($body)) !!}</p>
<p><a href="{{ $listingUrl }}">View listing</a></p>
