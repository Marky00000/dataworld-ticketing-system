@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{ asset('images/dwcc.png') }}" class="logo" alt="Dataworld Logo" style="max-height: 60px;">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>