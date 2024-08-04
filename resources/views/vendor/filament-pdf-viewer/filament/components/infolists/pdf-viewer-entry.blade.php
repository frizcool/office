<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    @if(!empty($getState()))
        <iframe
            class="w-full"
            src="{{ $getRoute(array_values($getState())[0]) }}" style="min-height: {{ $getMinHeight() }};">
        </iframe>
    @elseif(!empty($getFileUrl()))
        <iframe
            class="w-full"
            src="{{ $getFileUrl() }}" style="min-height: {{ $getMinHeight() }};">
        </iframe>
    @endif
</x-dynamic-component>
