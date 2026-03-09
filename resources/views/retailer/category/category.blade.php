@extends('retailer.layout.retailermaster')
@section('content')
@section('title')
    Home Page - Emerald OMS
@endsection
<main>
    <section class="container py-4">
        <div class="col-12 mb-4">
            <div class="fs-6 fw-semibold mb-3">Ready Stock</div>
            @php
                $availableProjects = App\Models\Product::where('qty', '>', 0)
                    ->select('project_id', 'product_image')
                    ->get()
                    ->filter(function ($product) {
                        return !empty($product->product_image) &&
                            Illuminate\Support\Facades\File::exists(
                                public_path('upload/product/' . $product->product_image),
                            );
                    })
                    ->pluck('project_id')
                    ->unique()
                    ->values()
                    ->toArray();
                
                $electroProjectId = App\Models\Project::where('project_name', 'ELECTRO FORMING')->value('id');
                $solidIdols = App\Models\Project::where('project_name', 'SIL SOLID IDOL')->value('id');
                $jewellery = App\Models\Project::where('project_name', 'SIL CASTING')->value('id');
                $indiania = App\Models\Project::where('project_name', 'SIL INDIANIA')->value('id');
                $utensil = App\Models\Project::where('project_name', 'SIL UTENSIL')->value('id');
                $sjrumi = App\Models\Project::where('project_name', 'SJ-RUMI')->value('id');
                $coin = App\Models\Project::where('project_name', 'SIL COIN')->value('id');
                $payal = App\Models\Project::where('project_name', 'SIL PAYAL')->value('id');
                $efsj = App\Models\Project::where('project_name', 'EFSJ')->value('id');
                $featherlight = App\Models\Project::where('project_name', 'FEATHER LIGHT')->value('id');
                $impressa = App\Models\Project::where('project_name', 'SIL IMPRESSA')->value('id');
                $mmd = App\Models\Project::where('project_name', 'SIL MMD')->value('id');
                $kuwaiti = App\Models\Project::where('project_name', 'SIL KUWAITI')->value('id');
            @endphp
            <div class="category-card-items">
                @if (in_array($electroProjectId, $availableProjects))
                    <div class="category-card-item">
                        <a href="{{ route('retailerefreadystock') }}" class="text-decoration-none">
                            <div class="card category-page-card">
                                <div class="card-body">
                                    <div class="d-flex flex-column gap-2 align-items-center">
                                        <div>
                                            <img width="50" height="50" class="category-card-img"
                                                src="{{ asset('retailer/assets/img/electro-forming.png') }}"
                                                alt="">
                                        </div>
                                        <div class="category-card-item-text">
                                            Electro Forming
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if (in_array($solidIdols, $availableProjects))
                    <div class="category-card-item">
                        <a href="{{ route('retailersireadystock') }}" class="text-decoration-none">
                            <div class="card category-page-card">
                                <div class="card-body">
                                    <div class="d-flex flex-column gap-2 align-items-center">
                                        <div>
                                            <img width="50" height="50" class="img-fluid ratio category-card-img"
                                                src="{{ asset('retailer/assets/img/solid-idols.png') }}" alt="">
                                        </div>
                                        <div class="category-card-item-text">
                                            Solid Idols
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if (in_array($jewellery, $availableProjects))
                    <div class="category-card-item">
                        <a href="{{ route('retailerjewelleryreadystock') }}" class="text-decoration-none">
                            <div class="card category-page-card">
                                <div class="card-body">
                                    <div class="d-flex flex-column gap-2 align-items-center">
                                        <div>
                                            <img width="50" height="50" class="category-card-img"
                                                src="{{ asset('retailer/assets/img/jewellery.png') }}" alt="">
                                        </div>
                                        <div class="category-card-item-text">
                                            Jewellery
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if (in_array($indiania, $availableProjects))
                    <div class="category-card-item">
                        <a href="{{ route('retailerindianiareadystock') }}" class="text-decoration-none">
                            <div class="card category-page-card">
                                <div class="card-body">
                                    <div class="d-flex flex-column gap-2 align-items-center">
                                        <div>
                                            <img width="50" height="50" class="category-card-img"
                                                src="{{ asset('retailer/assets/img/indiania.png') }}" alt="">
                                        </div>
                                        <div class="category-card-item-text">
                                            Indiania
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if (in_array($utensil, $availableProjects))
                    <div class="category-card-item">
                        <a href="{{ route('retailerutensilreadystock') }}" class="text-decoration-none">
                            <div class="card category-page-card">
                                <div class="card-body">
                                    <div class="d-flex flex-column gap-2 align-items-center">
                                        <div>
                                            <img width="50" height="50" class="category-card-img"
                                                src="{{ asset('retailer/assets/img/utensil.png') }}" alt="">
                                        </div>
                                        <div class="category-card-item-text">
                                            Utensil
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if (in_array($sjrumi, $availableProjects))
                    <div class="category-card-item">
                        <a href="{{ route('retailerSJrumireadyStock') }}" class="text-decoration-none">
                            <div class="card category-page-card">
                                <div class="card-body">
                                    <div class="d-flex flex-column gap-2 align-items-center">
                                        <div>
                                            <img width="50" height="50" class="category-card-img"
                                                src="{{ asset('retailer/assets/img/sj-rumi.png') }}" alt="">
                                        </div>
                                        <div class="category-card-item-text">
                                            SJ Rumi
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if (in_array($coin, $availableProjects))
                    <div class="category-card-item">
                        <a href="{{ route('retailercoinreadystock') }}" class="text-decoration-none">
                            <div class="card category-page-card">
                                <div class="card-body">
                                    <div class="d-flex flex-column gap-2 align-items-center">
                                        <div>
                                            <img width="50" height="50" class="category-card-img"
                                                src="{{ asset('retailer/assets/img/coin.png') }}" alt="">
                                        </div>
                                        <div class="category-card-item-text">
                                            Coin
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if (in_array($payal, $availableProjects))
                    <div class="category-card-item">
                        <a href="{{ route('retailerpayalreadystock') }}" class="text-decoration-none">
                            <div class="card category-page-card">
                                <div class="card-body">
                                    <div class="d-flex flex-column gap-2 align-items-center">
                                        <div>
                                            <img width="50" height="50" class="category-card-img"
                                                src="{{ asset('retailer/assets/img/payal.png') }}" alt="">
                                        </div>
                                        <div class="category-card-item-text">
                                            Payal
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if (in_array($efsj, $availableProjects))
                    <div class="category-card-item">
                        <a href="{{ route('retailerefsjreadystock') }}" class="text-decoration-none">
                            <div class="card category-page-card">
                                <div class="card-body">
                                    <div class="d-flex flex-column gap-2 align-items-center">
                                        <div>
                                            <img width="50" height="50" class="category-card-img"
                                                src="{{ asset('retailer/assets/img/efsj.png') }}" alt="">
                                        </div>
                                        <div class="category-card-item-text">
                                            EFSJ
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if (in_array($featherlight, $availableProjects))
                    <div class="category-card-item">
                        <a href="{{ route('retailerfeatherlightreadystock') }}" class="text-decoration-none">
                            <div class="card category-page-card">
                                <div class="card-body">
                                    <div class="d-flex flex-column gap-2 align-items-center">
                                        <div>
                                            <img width="50" height="50" class="category-card-img"
                                                src="{{ asset('retailer/assets/img/feather-light.png') }}"
                                                alt="">
                                        </div>
                                        <div class="category-card-item-text">
                                            Feather Light
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if (in_array($impressa, $availableProjects))
                    <div class="category-card-item">
                        <a href="{{ route('retailerimpressareadystock') }}" class="text-decoration-none">
                            <div class="card category-page-card">
                                <div class="card-body">
                                    <div class="d-flex flex-column gap-2 align-items-center">
                                        <div>
                                            <img width="50" height="50" class="category-card-img"
                                                src="{{ asset('retailer/assets/img/impressa.png') }}" alt="">
                                        </div>
                                        <div class="category-card-item-text">
                                            Impressa
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if (in_array($mmd, $availableProjects))
                    <div class="category-card-item">
                        <a href="{{ route('retailermmdreadystock') }}" class="text-decoration-none">
                            <div class="card category-page-card">
                                <div class="card-body">
                                    <div class="d-flex flex-column gap-2 align-items-center">
                                        <div>
                                            <img width="50" height="50" class="category-card-img"
                                                src="{{ asset('retailer/assets/img/mmd.png') }}" alt="">
                                        </div>
                                        <div class="category-card-item-text">
                                            MMD
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if (in_array($kuwaiti, $availableProjects))
                    <div class="category-card-item">
                        <a href="#" class="text-decoration-none">
                            <div class="card category-page-card">
                                <div class="card-body">
                                    <div class="d-flex flex-column gap-2 align-items-center">
                                        <div>
                                            <img width="50" height="50" class="category-card-img"
                                                src="{{ asset('retailer/assets/img/kuwaiti.png') }}" alt="">
                                        </div>
                                        <div class="category-card-item-text">
                                            Kuwaiti
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
            </div>
        </div>
        @if (Auth::user()->role_id == 3)
            <div class="col-12">
                <div class="fs-6 fw-semibold mb-3">Made to Order</div>

                <div class="category-card-items">
                    @if (in_array($electroForming, $availableProjects))
                        <div class="category-card-item">
                            <a href="{{ route('efstock') }}" class="text-decoration-none">
                                <div class="card category-page-card">
                                    <div class="card-body">
                                        <div class="d-flex flex-column gap-2 align-items-center">
                                            <div>
                                                <img width="50" height="50" class="category-card-img"
                                                    src="{{ asset('retailer/assets/img/electro-forming.png') }}"
                                                    alt="">
                                            </div>
                                            <div class="category-card-item-text">
                                                Electro Forming
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                    @if (in_array($solidIdols, $availableProjects))
                        <div class="category-card-item">
                            <a href="{{ route('sistock') }}" class="text-decoration-none">
                                <div class="card category-page-card">
                                    <div class="card-body">
                                        <div class="d-flex flex-column gap-2 align-items-center">
                                            <div>
                                                <img width="50" height="50"
                                                    class="img-fluid ratio category-card-img"
                                                    src="{{ asset('retailer/assets/img/solid-idols.png') }}"
                                                    alt="">
                                            </div>
                                            <div class="category-card-item-text">
                                                Solid Idols
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                    @if (in_array($jewellery, $availableProjects))
                        <div class="category-card-item">
                            <a href="{{ route('jewellerystock') }}" class="text-decoration-none">
                                <div class="card category-page-card">
                                    <div class="card-body">
                                        <div class="d-flex flex-column gap-2 align-items-center">
                                            <div>
                                                <img width="50" height="50" class="category-card-img"
                                                    src="{{ asset('retailer/assets/img/jewellery.png') }}"
                                                    alt="">
                                            </div>
                                            <div class="category-card-item-text">
                                                Jewellery
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                    @if (in_array($indiania, $availableProjects))
                        <div class="category-card-item">
                            <a href="{{ route('indianiastock') }}" class="text-decoration-none">
                                <div class="card category-page-card">
                                    <div class="card-body">
                                        <div class="d-flex flex-column gap-2 align-items-center">
                                            <div>
                                                <img width="50" height="50" class="category-card-img"
                                                    src="{{ asset('retailer/assets/img/indiania.png') }}"
                                                    alt="">
                                            </div>
                                            <div class="category-card-item-text">
                                                Indiania
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                    @if (in_array($utensil, $availableProjects))
                        <div class="category-card-item">
                            <a href="{{ route('utensilstock') }}" class="text-decoration-none">
                                <div class="card category-page-card">
                                    <div class="card-body">
                                        <div class="d-flex flex-column gap-2 align-items-center">
                                            <div>
                                                <img width="50" height="50" class="category-card-img"
                                                    src="{{ asset('retailer/assets/img/utensil.png') }}"
                                                    alt="">
                                            </div>
                                            <div class="category-card-item-text">
                                                Utensil
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </section>
</main>
@endsection
