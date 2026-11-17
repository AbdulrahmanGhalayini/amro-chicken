@if ($getState())
    <div class="space-y-2">
        <p class="text-sm font-medium text-gray-700">Image</p>
        <img 
            src="{{ asset('storage/' . $getState()) }}" 
            alt="Category Image"
            class="max-w-md h-auto rounded-lg shadow-md"
            onerror="this.style.display='none'"
        />
    </div>
@else
    <div class="text-gray-400">No image</div>
@endif
