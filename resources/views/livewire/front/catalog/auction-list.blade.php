<div>
    <section class="col">
        @foreach ($auctions as $auction)
            <div class="row mx-n2 mb-3" v-if="products.total">
                <div class="col-md-3 col-6 px-2 mb-4 d-flex align-items-stretch">
                    <div class="card product-card shadow pb-2">
                        <a class="card-img-top d-block overflow-hidden">
                            <img loading="lazy" :src="{{ $auction->image }}" width="250" height="300">
                        </a>
                        <div class="card-body py-2">
                            <h3 class="product-title fs-sm mt-2 mb-1"><a :href="origin + product.url">{{ $auction->name }}</a></h3>
                            <div class="product-price">
                                <span class="text-primary">{{ $auction->current_price }}</span>

                            </div>
                        </div>
                        <div class="product-floating-btn">
                            <a class="btn btn-primary btn-shadow btn-sm" href="{{ route('catalog.route', ['group' => \Illuminate\Support\Str::slug($auction->group), 'auction' => $auction]) }}">+<i class="ci-cart fs-base ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        {{ $auctions->links() }}
    </section>
</div>
