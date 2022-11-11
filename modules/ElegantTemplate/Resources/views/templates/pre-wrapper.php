<!-- pre-wrapper -->
<div id='pre-wrapper'>
    <section class='section section-steps'>
        <div class='packer'>
            <div class='package'>
                <div class='heading align-center'>
                    <h3>Order delivery online<br>in 3 simple steps</h3>
                </div>
                <div class='items'>
                    <?php foreach ([
                        ["name" => "Enter your address"],
                        ["name" => "Select a store"],
                        ["name" => "Make your order"]
                    ] as $item) :
                    ?>
                        <div class='item'>
                            <div class='item item-feature'>
                                <picture>
                                    <source srcset="https://placekitten.com/800/800" media="(min-width: 769px)" />
                                    <img loading="lazy" src='https://placekitten.com/400/400' />
                                </picture>
                                <div class='info'>
                                    <p class='mini-title'><?php echo $item["name"]; ?></p>
                                    <p>You can have as many addresses as you want.</p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
</div>