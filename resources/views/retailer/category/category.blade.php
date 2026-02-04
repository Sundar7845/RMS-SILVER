@extends('retailer.layout.retailermaster')
@section('content')
@section('title')
    Home Page - Emerald OMS
@endsection
<main>
    <section class="container py-4">
        <div class="col-12 mb-4">
            <div class="fs-6 fw-semibold mb-3">Ready Stock</div>

            <div class="category-card-items">
                <div class="category-card-item">
                    <a href="{{ route('retailerefreadystock') }}" class="text-decoration-none">
                        <div class="card category-page-card">
                            <div class="card-body">
                                <div class="d-flex flex-column gap-2 align-items-center">

                                    <div>
                                        <img width="50" height="50" class=" category-card-img"
                                            src="{{ asset('retailer/assets/img/electro-forming.png') }}" alt="">
                                    </div>
                                    <div class="category-card-item-text">
                                        Electro Forming
                                    </div>


                                </div>
                            </div>
                        </div>
                    </a>
                </div>
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
                <div class="category-card-item">
                    <a href="{{ route('retailerjewelleryreadystock') }}" class="text-decoration-none">
                        <div class="card category-page-card">
                            <div class="card-body">
                                <div class="d-flex flex-column gap-2 align-items-center">

                                    <div>
                                        <img width="50" height="50" class=" category-card-img"
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
                <div class="category-card-item">
                    <a href="{{ route('retailerindianiareadystock') }}" class="text-decoration-none">
                        <div class="card category-page-card">
                            <div class="card-body">
                                <div class="d-flex flex-column gap-2 align-items-center">

                                    <div>
                                        <img width="50" height="50" class=" category-card-img"
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
                <div class="category-card-item">
                    <a href="{{ route('retailerutensilreadystock') }}" class="text-decoration-none">
                        <div class="card category-page-card">
                            <div class="card-body">
                                <div class="d-flex flex-column gap-2 align-items-center">

                                    <div>
                                        <img width="50" height="50" class=" category-card-img"
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
            </div>
        </div>

        <div class="col-12">
            <div class="fs-6 fw-semibold mb-3">Made to Order</div>

            <div class="category-card-items">
                <div class="category-card-item">
                    <a href="{{ route('efstock') }}" class="text-decoration-none">
                        <div class="card category-page-card">
                            <div class="card-body">
                                <div class="d-flex flex-column gap-2 align-items-center">

                                    <div>
                                        <img width="50" height="50" class=" category-card-img"
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
                <div class="category-card-item">
                    <a href="{{ route('sistock') }}" class="text-decoration-none">
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
                <div class="category-card-item">
                    <a href="{{ route('jewellerystock') }}" class="text-decoration-none">
                        <div class="card category-page-card">
                            <div class="card-body">
                                <div class="d-flex flex-column gap-2 align-items-center">

                                    <div>
                                        <img width="50" height="50" class=" category-card-img"
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
                <div class="category-card-item">
                    <a href="{{ route('indianiastock') }}" class="text-decoration-none">
                        <div class="card category-page-card">
                            <div class="card-body">
                                <div class="d-flex flex-column gap-2 align-items-center">

                                    <div>
                                        <img width="50" height="50" class=" category-card-img"
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
                <div class="category-card-item">
                    <a href="{{ route('utensilstock') }}" class="text-decoration-none">
                        <div class="card category-page-card">
                            <div class="card-body">
                                <div class="d-flex flex-column gap-2 align-items-center">

                                    <div>
                                        <img width="50" height="50" class=" category-card-img"
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
            </div>
        </div>

    </section>
</main>
@endsection
