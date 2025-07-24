@extends('layouts.front_product')
@section('body')

 
    <!-- Body main wrapper start -->
    <main>
 
       <!-- Breadcrumb area start  -->
       <div class="breadcrumb__area theme-bg-1 p-relative z-index-11 pt-95 pb-95">
          <div class="breadcrumb__thumb" data-background="{{url('/uploads/FOREVER-MEDSPA')}}/Slide_4.jpg"></div>
          <div class="container">
             <div class="row justify-content-center">
                <div class="col-xxl-12">
                   <div class="breadcrumb__wrapper text-center">
                      <h4 class="breadcrumb__title">Welcome to the world of Forever Medspa.</h4>
                      <center><div class="nav_class">
                         <h6 style="color: white;opacity: 100%;">Avail these amazing Services Now!</h6>
                      </div>
                   </center>
                      <div class="breadcrumb__menu">
                         <nav>
                            <ul>
                               <li><span><a href="{{url('/')}}">Home</a></span></li>
                               <li><span>Services</span></li>
                            </ul>
                         </nav>
                      </div>
                   </div>
                </div>
             </div>
          </div>
       </div>
       <!-- Breadcrumb area start  -->

      <!-- Service details area start -->
      <section class="service-details-area section-space">
         <div class="container">
            <div class="row align-items-center">
               <div class="col-xxl-6 col-xl-6 col-lg-6">
                  <div class="section-title-wrapper-2 mb-15">
                     <span class="section-subtitle-2 mb-25">DIAGNOSTIC CENTER</span>
                     <h2 class="section-title">We use X-ray Technology to capture images</h2>
                  </div>
               </div>
               <div class="col-xxl-6 col-xl-6 col-lg-6">
                  <p>Morbi quam velit, euismod in imperdiet vitae, elementum et elit. Nunc finibus, felis sit amet
                     sollicitudin sollicitudin, nisi magna feugiat enim, in maximus urna enim ac tortor. Nunc in
                     volutpat ipsum, molestie commodo odio. Quisque auctor nisi mi. Aenean venenatis sapien et interdum
                     interdum.</p>
                  <p>Lorem ipsum dolor sit amet consectetur adipiscing elit Ut et massa mi. Aliquam in hendrerit urna.
                     Pellentesque sit amet sapien.</p>
               </div>
            </div>
            <div class="row">
               <div class="col-12">
                  <div class="service-details-thumb mt-80 mb-80">
                     <img src="{{url('/product_page')}}/imgs/service/service-big-01.jpg" alt="" onerror="this.onerror=null; this.src='{{url('/No_Image_Available.jpg')}}';">
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-xxl-6 col-xl-6 col-lg-6">
                  <div class="section-title-wrapper-2">
                     <h2 class="section-title">What do you need to get going?</h2>
                  </div>
               </div>
               <div class="col-xxl-6 col-xl-6 col-lg-6">
                  <p>Morbi quam velit, euismod in imperdiet vitae, elementum et elit. Nunc finibus, felis sit amet
                     sollicitudin sollicitudin, nisi magna feugiat enim, in maximus urna enim ac tortor. Nunc in
                     volutpat ipsum, molestie commodo odio. Quisque auctor nisi mi. Aenean venenatis sapien et interdum
                     interdum.</p>
                  <p>Lorem ipsum dolor sit amet consectetur adipiscing elit Ut et massa mi. Aliquam in hendrerit urna.
                     Pellentesque sit amet sapien.</p>
               </div>
            </div>
         </div>
      </section>
      <!-- Service details area end -->

      <!-- Benefit area star -->
      <div class="benefit-area theme-bg-2 pt-80 pb-80">
         <div class="container">
            <div class="row g-5 justify-content-center">
               <div class="col-xxl-3 cl-xl-3 col-lg-3 col-md-6">
                  <div class="benefit-item text-center">
                     <div class="benefit-round">
                        <h3><span class="counter">89</span>%</h3>
                        <span class="benefit-count">01</span>
                     </div>
                     <div class="benefit-content">
                        <h3>Medical Project</h3>
                        <p> Pellentesque commodo lacus at sodales sodales.</p>
                     </div>
                  </div>
               </div>
               <div class="col-xxl-3 cl-xl-3 col-lg-3 col-md-6">
                  <div class="benefit-item text-center">
                     <div class="benefit-round">
                        <h3><span class="counter">78</span>%</h3>
                        <span class="benefit-count">02</span>
                     </div>
                     <div class="benefit-content">
                        <h3>Medical Eng.</h3>
                        <p> Pellentesque commodo lacus at sodales sodales.</p>
                     </div>
                  </div>
               </div>
               <div class="col-xxl-3 cl-xl-3 col-lg-3 col-md-6">
                  <div class="benefit-item text-center">
                     <div class="benefit-round">
                        <h3><span class="counter">94</span>%</h3>
                        <span class="benefit-count">03</span>
                     </div>
                     <div class="benefit-content">
                        <h3>Support</h3>
                        <p> Pellentesque commodo lacus at sodales sodales.</p>
                     </div>
                  </div>
               </div>
               <div class="col-xxl-3 cl-xl-3 col-lg-3 col-md-6">
                  <div class="benefit-item text-center">
                     <div class="benefit-round">
                        <h3><span class="counter">90</span>%</h3>
                        <span class="benefit-count">04</span>
                     </div>
                     <div class="benefit-content">
                        <h3>Medicine of Health</h3>
                        <p> Pellentesque commodo lacus at sodales sodales.</p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Benefit area end -->

      <!-- FAQ area start -->
      <section class="faq__area section-space">
         <div class="container">
            <div class="row gy-50 wow fadeInUp" data-wow-delay=".3s">
               <div class="col-xxl-5 col-xl-5 col-lg-6">
                  <div class="faq__content bd-sticky">
                     <div class="section-title-wrapper-2 mb-15">
                        <span class="section-subtitle-2 mb-25">Read Faq</span>
                        <h2 class="section-title">There are many common questions here!</h2>
                     </div>
                     <p class="mb-40">Lorem ipsum dolor sit amet consectetur adipisci elit Ut massa mi. Aliquam in
                        hendrerit.</p>
                     <a href="contact.html" class="fill-btn">
                        <span class="fill-btn-inner">
                           <span class="fill-btn-normal">Contact Now<i class="fa-regular fa-angle-right"></i></span>
                           <span class="fill-btn-hover">Contact Now<i class="fa-regular fa-angle-right"></i></span>
                        </span>
                     </a>
                  </div>
               </div>
               <div class="col-xxl-7 col-xl-7 col-lg-6">
                  <div class="bd__faq">
                     <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                           <h2 class="accordion-header" id="headingOne">
                              <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                 data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                 What are the required in a portfolio?
                              </button>
                           </h2>
                           <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                              data-bs-parent="#accordionExample">
                              <div class="accordion-body">
                                 <p>Pellentesque commodo lacus at sodales sodales. uisque sagittis orci ut diam
                                    condimentum, vel euismod erat Pellentesque commodo lacus at sodales sodales. Quisque
                                    . placerat. In iaculis arcu eros, eget tempus orci facilisis id. Morbi quam velit,
                                    euismd in imperdiet vitae.</p>
                              </div>
                           </div>
                        </div>
                        <div class="accordion-item">
                           <h2 class="accordion-header" id="headingTwo">
                              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                 data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                 What is the research-based assessment?
                              </button>
                           </h2>
                           <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                              data-bs-parent="#accordionExample">
                              <div class="accordion-body">
                                 <p>Pellentesque commodo lacus at sodales sodales. uisque sagittis orci ut diam
                                    condimentum, vel euismod erat Pellentesque commodo lacus at sodales sodales. Quisque
                                    . placerat. In iaculis arcu eros, eget tempus orci facilisis id. Morbi quam velit,
                                    euismd in imperdiet vitae.</p>
                              </div>
                           </div>
                        </div>
                        <div class="accordion-item">
                           <h2 class="accordion-header" id="headingThree">
                              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                 data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                 What are the required in a portfolio?
                              </button>
                           </h2>
                           <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                              data-bs-parent="#accordionExample">
                              <div class="accordion-body">
                                 <p>Pellentesque commodo lacus at sodales sodales. uisque sagittis orci ut diam
                                    condimentum, vel euismod erat Pellentesque commodo lacus at sodales sodales. Quisque
                                    . placerat. In iaculis arcu eros, eget tempus orci facilisis id. Morbi quam velit,
                                    euismd in imperdiet vitae.</p>
                              </div>
                           </div>
                        </div>
                        <div class="accordion-item">
                           <h2 class="accordion-header" id="headingFour">
                              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                 data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                 How to send money online?
                              </button>
                           </h2>
                           <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                              data-bs-parent="#accordionExample">
                              <div class="accordion-body">
                                 <p>Pellentesque commodo lacus at sodales sodales. uisque sagittis orci ut diam
                                    condimentum, vel euismod erat Pellentesque commodo lacus at sodales sodales. Quisque
                                    . placerat. In iaculis arcu eros, eget tempus orci facilisis id. Morbi quam velit,
                                    euismd in imperdiet vitae.</p>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- FAQ area end -->

    

   </main>
   <!-- Body main wrapper end -->
@endsection
@push('footerscript')
<script src="{{url('/')}}/giftcards/js/custom.js"></script>
<script src="{{url('/')}}/giftcards/js/giftcard.js"></script>
@endpush
