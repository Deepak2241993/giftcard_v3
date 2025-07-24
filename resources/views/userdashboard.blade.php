<div class="row">
    <div class="col-xl-3 col-md-6">
        <!-- card -->
        <div class="card card-h-100">
           
            <!-- card body -->
            <div class="card-body">
                <a href="{{route('gift.index')}}">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1" >
                        <span class="text-muted mb-3 lh-1 d-block text-truncate">Total Giftcards</span>
                        <h4 class="mb-3">
                            <span class="counter-value" data-target="{{$gift_buy}}"></span>
                        </h4>
                       
                    </div>

                    <div class="flex-shrink-0 text-end dash-widget">
                        <div id="mini-chart1" data-colors='["#1c84ee", "#33c38e"]' class="apex-charts"></div>
                    </div>
                </div></a>
            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->

</div><!-- end row-->