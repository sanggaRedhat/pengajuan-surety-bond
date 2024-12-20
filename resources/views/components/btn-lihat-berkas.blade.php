@if ($file != '' || $file != null)
    <button onclick="window.open('{{ route('view_berkas', ['filename'=>BerkasHelper::getFilename($file),'path'=>BerkasHelper::getPath($file)]) }}')" class="btn btn-xs btn-info" target="_blank">
        Lihat
    </button>
@else
    -
@endif
