@extends('layouts.app')
@section('content')
    <div class="flex justify-center gap-4 border-b pb-10">
        <div class="max-w-lg">
            <div class="rounded-3xl">
                <div class="w-auto rounded-3xl">
                    <div class="grid grid-cols-2 grid-rows-1 gap-4">
                        <div><img src="{{ asset('img/' . $data->foto) }}" class="rounded-lg"></div>
                        <div>
                            <div class="flex justify-start">
                                <img class="w-10 h-10 rounded-full"
                                    src="https://flowbite.com/docs/images/people/profile-picture-3.jpg" alt="user photo">
                                <p class="text-xl ml-5">{{ $data->user->username }}</p>
                                <p class=" text-sm pt-2 pl-3 text-gray-400">{{ $data->created_at->format('d M Y') }}</p>
                            </div>

                            @if ($data->user->id == Auth::user()->id)
                                <div class="flex justify-end text-xl">
                                    <button data-modal-target="static-modal" data-modal-toggle="static-modal"
                                        class="bloc font-medium rounded-lg text-xl text-center" type="button">
                                        <a class="pr-2"><i class="fa-solid fa-pen-to-square text-blue-700"></i></a>
                                    </button>

                                    <a href="/foto/delete/{{ $data->id }}"><i
                                            class="fa-solid fa-trash text-red-600"></i></a>
                                </div>
                            @endif

                            <h5 class="mb-2 mt-3 text-2xl font-bold tracking-tight border-t text-gray-900 dark:text-white">
                                {{ $data->judul }}</h5>
                            <p class="font-normal text-gray-700 border-t border-b dark:text-gray-400">{{ $data->deskripsi }}
                            </p>
                            <div class="overflow-y-auto max-h-64">
                                @foreach ($comentar as $item)
                                    <div class="flex items-center gap-4 mb-5">
                                        <img class="w-8 h-8 rounded-full"
                                            src="https://flowbite.com/docs/images/people/profile-picture-3.jpg"
                                            alt="">
                                        <div class="font-medium dark:text-white">
                                            <div>{{ $item->user->username }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $item->comentar }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <p>{{ $liked->count() }}</p>
                            @if ($liked->contains('user_id', Auth::user()->id))
                                <form method="POST" action="{{ route('unlike', $data->id) }}">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                    <input type="hidden" name="_method" value="POST"> {{-- Add this hidden input --}}
                                    <button type="submit" class="pt-5 flex justify-end">

                                        <i class="fa-solid fa-heart text-xl text-red-600"></i>

                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('like', $data->id) }}">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                    <button type="submit" class="pt-5 flex justify-end">


                                        <i class="fa-regular fa-heart text-xl"></i>
                                    </button>
                                </form>
                            @endif


                            <form action="/coment/{{ $data->id }}" method="post">
                                @csrf
                                <input type="text" hidden name="foto_id" value="{{ $data->id }}">
                                <div class="flex pt-1">
                                    <input type="text" name="comentar" id="small-input"
                                        class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <button type="submit">
                                        <i class="fa-solid fa-paper-plane text-xl float-end text-gray-800 pl-2 pt-1"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Main modal -->
    <div id="static-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Edit Detail Foto
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="static-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
                    <form class="max-w-lg mx-auto grid gap-4 grid-cols-2" action="upload" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <div>
                            <label for="base-input"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Judul</label>
                            <input name="judul" type="text" id="base-input"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                        <div class="mb-5">
                            <label for="large-input"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi</label>
                            <input name="deskripsi" type="text" id="large-input"
                                class="block w-full p-4 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                    </form>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button data-modal-hide="static-modal" type="button"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection
