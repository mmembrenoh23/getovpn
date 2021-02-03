
    @if ($dir->count() > 0)
        @foreach ($dir as $item)
        <div class="col-lg-3 col-md-12">
                <div class="card server"  data-route="{{ route('server',['server_id'=>base64_encode($item->id)]) }}">
                    <div class="card-body">
                        <h4 class="card-title">{{ $item->server_name }}</h4>
                    </div>
                    <div class="card-body">
                        <i class="ft-server display-1"></i>
                    </div>

                </div>
            </div>
        @endforeach
        <div class="col-12">
            <div class="text-center mb-3">
                {{ $dir->withQueryString()->links() }}
            </div>
        </div>
    @else
    <div class="col-2">

    </div>
      <div class="col-xl-8 col-lg-12">
         <div class="alert alert-warning alert-dismissible alert-light mb-2" role="alert">
            <h4 class="alert-heading mb-2">Ooh oh!</h4>
            <p>No results containing all your search terms were found</p>
        </div>

    </div>
    <div class="col-2">

    </div>
    @endif

