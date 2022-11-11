
<!-- areas-->
<section class='section section-areas'>
    <div class='packer'>
        <div class='package'>
            <div class='content'>
                <div class='heading'>
                    <h2>FAQ</h2>
                </div>
                <div class=''>
                    <?php foreach (["What is efood?", "What are the payment methods that I have?", "Where can I find the menu and the prices of a store?", "Do I need to give my cellphone number to order?"] as $item) : ?>
                        <div class='accordion'>
                            <div class='accordion_head collapse-all'>
                                <a class='collapse' href='javascript:;'>
                                    <i class="las la-angle-down"></i>
                                </a>
                                <div class='accordion_title'><a href='javascript:;'><?php echo $item; ?></a></div>
                            </div>
                            <div class='accordion_content'>
                                <p>Yes, you will need to provide a mobile phone number before placing your first order. A confirmation SMS will be sent to this number.</p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>