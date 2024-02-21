@extends('layouts.app')
@section('content')
    <div class="p-5 sm:p-8">
        <div class="columns-1 gap-5 sm:columns-2 sm:gap-8 md:columns-3 lg:columns-5 [&>img:not(:first-child)]:mt-8">
            @foreach ($data as $item)
                <a href="/detail/{{ $item->id }}"><img class="rounded-lg mb-5"
                        src="{{ asset('img/' . $item->foto) }}" /></a>
            @endforeach
        </div>
    </div>
@endsection
