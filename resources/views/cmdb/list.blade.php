<?php
$cmdb = json_decode(json_encode($cmdb));
?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('CMDB') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 pb-2 text-gray-900 dark:text-gray-100">
                    {{ __("Listado de CMDB") }}
                </div>

                @if ($message = Session::get('success'))
                <div class="p-3">
                    <div class="p-6 bg-teal-500 text-sm text-white rounded-lg" role="alert">
                        <span class="font-bold"></span> {{ $message }}
                    </div>
                </div>
                @endif

                <div class="flex flex-col">
                    <div class="-m-1.5 overflow-x-auto">
                        <div class="p-1.5 min-w-full inline-block align-middle">
                            <div class="grid grid-cols-2 gap-">
                                <div class="py-3 px-4">
                                    <form method="GET" id="category-filter" class="display: inline" action="{{ route('cmdb.list') }}">
                                        <div class="relative max-w-xs">
                                            <select name="category_id" class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" onchange="document.getElementById('category-filter').submit()">
                                                <option selected  value="">Categoria</option>
                                                @foreach ($categories as $category)
                                                    <option {!! request()->get('category_id') == $category->id ? "selected" : "" !!} value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </form>
                                    @if(request()->get('category_id'))
                                    <form method="GET" id="export" class="display: inline" action="{{ route('cmdb.export') }}">
                                        <input type="hidden" name="category_id" value="{{ request()->get('category_id') }}">
                                        <button type="button" onclick="document.getElementById('export').submit()" class="py-3 px-4 inline-flex items-center gap-x-2 -ms-px first:rounded-s-lg first:ms-0 last:rounded-e-lg text-sm font-medium focus:z-10 border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800 dark:focus:bg-neutral-800">
                                            Exportar
                                        </button>
                                    </form>
                                    @endif
                                    <form method="post" id="import" class="display: inline" action="{{ route('cmdb.import') }}">
                                        @csrf
                                        <button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 -ms-px first:rounded-s-lg first:ms-0 last:rounded-e-lg text-sm font-medium focus:z-10 border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800 dark:focus:bg-neutral-800">
                                            Importar
                                            <input type="file" name="archivo" onchange="document.getElementById('import').submit()" style="width: 100%; height: 100%; opacity: 0;"></input>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead>
                                        <tr>
                                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Identificador</th>
                                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Nombre</th>
                                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Categoria</th>
                                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Campos opcionales</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($cmdb as $row)
                                            <tr class="odd:bg-white even:bg-gray-100 dark:odd:bg-slate-900 dark:even:bg-slate-800">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">{{ $row->identificator  }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{{ $row->name  }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{{ $categories->firstWhere('id', $row->category_id )->name ?? null }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{{ implode(', ', $categories->firstWhere('id', $row->category_id )->cmdb_fields) ?? null }}</td>
                                            </tr>
                                        @empty
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">No se encontraron datos</td>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
