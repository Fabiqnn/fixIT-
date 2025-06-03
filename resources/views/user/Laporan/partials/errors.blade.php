@if ($errors->any())
    <div class="bg-red-200 text-red-800 p-3 mb-4 rounded">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if ($errors->has('deskripsi'))
    <p class="text-red-600 text-sm mt-1">{{ $errors->first('deskripsi') }}</p>
@endif
