<div class="modal fade custom-modal" id="quickViewModal" tabindex="-1" aria-labelledby="quickViewModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" id="closeModal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12 mb-md-0 mb-sm-5">
                        <div class="detail-gallery">
                            <span class="zoom-icon"><i class="fi-rs-search"></i></span>
                            <!-- MAIN SLIDES -->

                            <img id="modalImage" alt="product image" />

                            <!-- THUMBNAILS -->

                        </div>
                        <!-- End Gallery -->
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="detail-info pr-30 pl-30">

                            <h3 class="title-detail"><a class="text-heading" id="modalHeading"></a></h3>
                            <div class="product-detail-rating">
                                <div class="product-rate-cover text-end">
                                    <div class="product-rate d-inline-block">
                                        <div class="product-rating" style="width: 90%"></div>
                                    </div>
                                    <span class="font-small ml-5 text-muted"> (32 reviews)</span>
                                </div>
                            </div>
                            <div class="clearfix product-price-cover">
                                <div class="product-price primary-color float-left" id="modalPrice">

                                </div>
                            </div>
                            <div class="attr-detail attr-size mb-10">
                                <strong class="mr-10">Size</strong>

                                <select name="size" id="modalSize">

                                </select>
                            </div>
                            <div class="attr-detail attr-size mb-10">
                                <strong class="mr-10">Color:</strong>
                                 <select name="color" id="modalColor">

                                 </select>
                                {{-- <ul class="list-filter size-filter font-small" id="modalColor">


                                </ul> --}}
                            </div>
                            <div class="detail-extralink mb-30">
                                <div class="detail-qty border radius">
                                    <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                    <input type="text" name="quantity" id="quantity" class="qty-val" value="1" min="1">
                                    <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                </div>
                                <div class="product-extra-link2">
                                    <input type="hidden" id="product_id">
                                    <button type="button" onclick="addCart()" class="button button-add-to-cart"><i
                                            class="fi-rs-shopping-cart"></i>Add to cart</button>
                                </div>
                            </div>
                            <div class="font-xs d-flex justify-content-between" id="modalExtra">

                            </div>
                        </div>
                        <!-- Detail Info -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
