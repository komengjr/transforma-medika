@extends('layouts.layouts')
@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<style>
    #button-pick-request {
        cursor: pointer;
    }

    #button-pick-request:hover {
        background: rgb(223, 217, 25);
    }

    #button-terima-order-barang-peminjaman:hover {
        background: rgb(223, 217, 25);
        cursor: pointer;
    }
</style>
@endsection
@section('content')
<div class="row mb-3 ">
    <div class="col">
        <div class="card bg-200 shadow border border-primary bg-primary">
            <div class="row gx-0 flex-between-center" style="color: white !important;">
                <div class="col-sm-auto d-flex align-items-center border-bottom">
                    <img class="ms-3 mx-3 m-2" src="{{ asset('img/app.png') }}" alt="" width="50" />
                    <div>
                        <h6 class="text-white fs--1 mb-0 pt-2">Welcome to </h6>
                        <h4 class="text-white fw-bold mb-1">{{env('APP_NAME')}} <span class="text-white fw-medium">Management
                                System</span></h4>
                    </div>
                    <img class="ms-n4 d-none d-lg-block "
                        src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                </div>
                <div class="col-xl-auto px-3 py-2">
                    <h6 class="text-white fs--1 mb-0">Menu : </h6>
                    <h4 class="text-white fw-bold mb-0">Tambah <span class="text-white fw-medium">Berita</span>
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card mb-3">
    <div class="card-header bg-primary">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="m-0"><span class="badge bg-primary m-0 p-0">Form Tambah Data Berita</span></h3>
            </div>
            <div class="col-auto">

            </div>
        </div>
    </div>
    <div class="card-body border-top p-3">
        <form class="row g-3" action="{{ route('menu_news_save') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="col-md-4">
                <label class="form-label" for="inputState">Kategori Berita</label>
                <select class="form-select" id="inputState" name="kategori" required>
                    <option value="">Choose...</option>
                    @foreach ($cat as $cats)
                    <option value="{{ $cats->news_categori_code }}">{{ $cats->news_categori_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-8">
                <label class="form-label" for="inputEmail4">Title Berita</label>
                <input class="form-control" id="inputEmail4" type="text" name="title" required/>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="inputPassword4">Slug Berita</label>
                <input class="form-control" id="inputPassword4" type="text" name="slug" required/>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="inputAddress">Thumbnail Berita</label>
                <input class="form-control" id="inputAddress" type="text" placeholder="link.." name="thumb" required/>
            </div>
            <div class="col-12">
                <label class="form-label" for="inputAddress2">Content Berita</label>
                <div class="min-vh-50">
                    <textarea class="tinymce d-none" name="content"></textarea>
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="inputCity">Author</label>
                <input class="form-control" id="inputCity" type="text" name="author" required/>
            </div>

            <div class="col-md-6">
                <label class="form-label" for="inputZip">Publish Berita</label>
                <input class="form-control" id="inputZip" type="date" name="publish" required/>
            </div>
            <div class="col-12">
                <div class="form-check">
                    <input class="form-check-input" id="gridCheck" type="checkbox" required/>
                    <label class="form-check-label" for="gridCheck">Check me out</label>
                </div>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Sign in</button>
            </div>
        </form>

    </div>
</div>
@endsection
@section('base.js')
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/tinymce/tinymce.min.js') }}"></script>
<script>
    new DataTable('#example', {
        responsive: true
    });
</script>
@endsection
