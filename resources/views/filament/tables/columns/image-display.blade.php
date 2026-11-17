@php
    $record = $this->evaluate($this->getRecord());
    $image = $record?->image;
@endphp

@if ($image)
    <img 
        src="{{ asset('storage/' . $image) }}" 
        alt="Image"
        class="w-16 h-12 object-cover rounded"
        onerror="this.style.display='none'"
    />
@else
    <span class="text-gray-400 text-sm">No image</span>
@endif
