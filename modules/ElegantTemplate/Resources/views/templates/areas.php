 
 <!-- areas-->
 <section class='section section-areas'>
     <div class='packer'>
         <div class='package'>
             <div class='content'>
                 <div class='heading'>
                     <h2>efood in every area </h2>
                 </div>
                 <div class=''>
                     <?php foreach (["Athina", "Thessaloniki", "Other Areas"] as $item) : ?>
                         <div class='accordion'>
                             <div class='accordion_head'>
                                 <a class='collapse' href='javascript:;'>
                                     <i class="las la-angle-down"></i>
                                 </a>
                                 <div class='accordion_title'><a href='javascript:;'><?php echo $item; ?></a></div>
                             </div>
                             <div class='accordion_content'>
                                 <nav class='grid-links'>
                                     <?php for ($i = 0; $i < 100; $i++) : ?>
                                         <div class='item'>
                                             <a href='place.php'>Coffee Island</a>
                                         </div>
                                     <?php endfor; ?>
                                 </nav>
                             </div>
                         </div>
                     <?php endforeach; ?>
                 </div>
             </div>
         </div>
     </div>
 </section>