 
 <!-- links-->
 <?php $rand = rand(1, 9999); ?>
 <section class='section section-links'>
     <div class='packer'>
         <div class='package'>
             <div class='content'>
                 <div class='heading-with-some'>
                     <div class='heading'>
                         <h2><span class='highlighter'>New</span> stores</h2>
                     </div>
                     <div class='custom-controls controls-<?php echo $rand; ?>'>
                         <a href='javascript:;'><i class="las la-angle-left"></i></a>
                         <a href='javascript:;'><i class="las la-angle-right"></i></a>
                     </div>
                 </div>
                 <div class='carousel gap-stuck'>
                     <div class='carousel_items' data-controlsContainer='.controls-<?php echo $rand; ?>' data-items=2 data-nav=0 data-controls=1 data-responsive-576='<?php echo json_encode(["items" => 3, "gutter" => 16]); ?>' data-responsive-768='<?php echo json_encode(["items" => 4, "gutter" => 16]); ?>'>
                         <?php for ($i = 0; $i < 10; $i++) : ?>
                             <div class='item'>
                                 <nav class='links'>
                                     <div class='item'>
                                         <a href='place.php'>Coffee Island</a>
                                     </div>
                                     <div class='item'>
                                         <a href='place.php'>The Big Bad Wolf</a>
                                     </div>
                                     <div class='item'>
                                         <a href='place.php'>Roma Pizza</a>
                                     </div>
                                     <div class='item'>
                                         <a href='place.php'>Pizza Fan</a>
                                     </div>
                                     <div class='item'>
                                         <a href='place.php'>Bullseye</a>
                                     </div>
                                     <div class='item'>
                                         <a href='place.php'>Mikel</a>
                                     </div>
                                 </nav>
                             </div>
                         <?php endfor; ?>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </section>