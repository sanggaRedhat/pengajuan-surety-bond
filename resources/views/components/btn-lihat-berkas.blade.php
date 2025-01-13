@if ($file != '' || $file != null)
    <button onclick="window.open('{{ route('view_berkas', ['filename'=>BerkasHelper::getFilename($file),'path'=>BerkasHelper::getPath($file)]) }}')" class="btn btn-xs btn-info d-print-none" target="_blank">
        Lihat
    </button>
    <span style="width: 50px" class="btn btn-xs btn-dark d-none d-print-inline">
        <i class="fa fa-check text-dark"></i>
    </span>
    @else
    <i class="fa fa-times text-dark d-print-none"></i>
    <span style="width: 50px" class="btn btn-xs btn-dark d-none d-print-inline">
        <i class="fa fa-check invisible"></i>
    </span>
@endif
