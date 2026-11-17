@php
    $record = $this->evaluate($this->getRecord());
    $image = $record?->profile_photo;
@endphp

@if ($image)
    <img 
        src="{{ asset('storage/' . $image) }}" 
        alt="Profile Photo"
        class="w-15 h-15 rounded-full object-cover"
        style="width: 60px; height: 60px;"
        onerror="this.style.display='none'"
    />
@else
    <span class="text-gray-400 text-sm">No image</span>
@endif
